<?php

namespace App;

use App\Enums\InvoiceType;
use App\Mail\BalanceNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Invoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'user_id', 'comment_id', 'credit', 'debit'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function (Invoice $invoice) {
            $invoice->checkLowBalance()
                ->checkBanBalance();
        });
    }

    public static function createCommentInvoice(Comment $comment)
    {
        if ($comment->user->comments()->count() > config('prices.free_comments')) {
            $comment->invoice()->create([
                'type' => InvoiceType::COMMENT,
                'user_id' => $comment->user_id,
                'debit' => config('prices.comment'),
            ]);
        }
    }

    public static function createRegistrationInvoice(User $user)
    {
        $user->invoices()->create([
            'type' => InvoiceType::REGISTER,
            'credit' => config('prices.registration'),
        ]);
    }

    public static function createArticleInvoice(Article $article)
    {
        $article->invoice()->create([
            'type' => InvoiceType::ARTICLE,
            'user_id' => $article->user_id,
            'debit' => config('prices.article'),
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function balance()
    {
        return $this->credit - $this->debit;
    }

    private function isCrossBalance($amount)
    {
        return $this->user->balance() - $this->balance() > $amount
            && $this->user->balance() <= $amount;
    }

    private function checkLowBalance()
    {
        if ($this->isCrossBalance(config('prices.low_balance'))) {
            Mail::to($this->user)->send(new BalanceNotification($this->user_id));
        }

        return $this;
    }

    private function checkBanBalance()
    {
        if ($this->isCrossBalance(config('prices.ban_balance'))) {
            $this->user->ban();
        }
    }
}
