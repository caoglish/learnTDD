<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    protected function setUp():void
    {
        parent::setUp();


        $this->thread=factory('App\Thread')->create();
    }

    public function test_a_user_can_browse_threads()
    {

        $response = $this->get('/threads');
//        $response->assertStatus(200);
        $response->assertSee($this->thread->title);

    }

    public function test_a_user_can_read_a_single_thread(){

        $response = $this->get('/threads/'.$this->thread->id);
        $response->assertSee($this->thread->title);

    }

    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply=facotry('App\Reply')->create(['thread_id'=>$this->thread_id]);

        $this->get('/threads/'.$this->thread->id)
            ->assertSee($reply->body);



    }
}
