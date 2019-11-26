<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest_user_can_not_create_new_forum_threads()
    {
        $this->withExceptionHanding();

        $this->post('/threads')
            ->assertRedirect('/login');

        $this->get('/threads/create')
            ->assertRedirect('/login');

        // $this->expectException('Illuminate\Auth\AuthenticationException');

        // $thread=make('App\Thread');
        // $this->post('/threads',$thread->toArray());

    }

    public function test_an_authenticated_user_can_create_new_forum_threads()
    {

        $this->signIn();

        $thread = create('App\Thread');
        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

}
