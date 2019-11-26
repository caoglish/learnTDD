<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    public function test_a_user_can_browse_threads()
    {
        $response = $this->get('/threads');
//        $response->assertStatus(200);
        $response->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_a_single_thread()
    {
        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }

    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = create('App\Reply', ['thread_id' => $this->thread_id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }
}
