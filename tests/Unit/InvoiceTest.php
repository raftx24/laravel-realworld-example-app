<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Enums\InvoiceType;
use App\Mail\BalanceNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class InvoiceTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_sends_email_when_balance_cross_low_balance()
    {
        Mail::fake();

        $this->user->invoices()->create([
            'type' => InvoiceType::REGISTER,
            'credit' => config('prices.low_balance') + 1
        ]);

        $this->user->invoices()->create([
            'type' => InvoiceType::COMMENT,
            'debit' => 1
        ]);

        Mail::assertSent(BalanceNotification::class, function ($mail) {
            return $mail->to[0]['address'] === $this->user->email;
        });
    }

    /** @test */
    public function it_should_not_send_email_when_balance_doesnt_cross_the_low_balance()
    {
        Mail::fake();

        $this->user->invoices()->delete();

        $this->user->invoices()->create([
            'type' => InvoiceType::COMMENT,
            'debit' => 1000
        ]);

        Mail::assertNotSent(BalanceNotification::class);
    }
}
