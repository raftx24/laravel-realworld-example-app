<?php

namespace Tests\Unit;

use App\User;
use App\Comment;
use App\Article;
use Tests\TestCase;
use Illuminate\Queue\Queue;
use App\Jobs\DeleteUserJob;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_deletes_articles_and_comments_when_user_deleted()
    {
        $user = factory(User::class)->create();

        $article = factory(Article::class)->create([
            'user_id' => $user->id
        ]);

        $comment = factory(Comment::class)->create([
            'user_id' => $user->id,
            'article_id' => $article->id
        ]);

        $user->delete();

        $this->assertEmpty(Article::all());
        $this->assertEmpty(Comment::all());
    }


    public function it_should_delete_user_after_user_was_banned()
    {
        Queue::fake();

        factory(User::class)->create()
            ->ban();

        Queue::assertPushed(DeleteUserJob::class);
    }
}
