<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    public function test_unauthenticated_users_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = create('App\Thread');
        $reply = create('App\Reply');

        $this->post($thread->path().'/replies', $reply->toArray());
        $this->assertRedirect('/login');
    }
    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        $user= create('App\User');
        $this->be($user);

        $thread = create('App\Thread');
        $reply = make('App\Reply');
       
        $this->post($thread->path().'/replies', $reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);
    }

    public function test_a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply',['body'=>null]);
        
        $this->post($thread->path().'/replies', $reply->toArray() )
             ->assertSessionHasErrors('body');
    }
}
