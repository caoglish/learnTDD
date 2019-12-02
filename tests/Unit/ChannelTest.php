<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChannelTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_channel_consists_of_threads()
    {
        $channel=create('App\Channel');
        $thread=create('App\Thread',['channel_id' => $channel->id]);

        //dd($channel->threads,$thread);
        $this->assertTrue($channel->threads->contains($thread));
        // $reply= factory('App\Reply')->create();

        // $this->assertInstanceOf('App\User',$reply->owner);
    }
}
