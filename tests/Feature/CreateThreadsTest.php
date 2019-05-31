<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_can_create_new_forum_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread=factory('App\Thread')->make();
        $this->post('/threads',$thread->toArray());

    }

    public function test_guest_user_can_not_create_new_forum_threads()
    {
        $this->actingAs(factory('App\User')->create());

        $thread=factory('App\Thread')->make();
        $this->post('/threads',$thread->toArray());
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
