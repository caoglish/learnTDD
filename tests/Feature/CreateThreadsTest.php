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
        $this->withExceptionHandling();

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

        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function test_a_thread_requries_a_title()
    {
        $this->publishThread(['title'=>null])
            ->assertSessionHasErrors('title');
      
    }

    public function test_a_thread_requries_a_body()
    {
        $this->publishThread(['body'=>null])
            ->assertSessionHasErrors('body');
      
    }

    public function test_a_thread_requries_a_valid_channel()
    {
        factory('App\Channel',2)->create();

        $this->publishThread(['channel_id'=>null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id'=>999])
            ->assertSessionHasErrors('channel_id');
      
    }

    public function publishThread($overrides = []){
        $this->withExceptionHandling()->signIn();

        $thread= make('App\Thread',$overrides);
        
     
        return $this->post('/threads', $thread->toArray());
        

    }


}
