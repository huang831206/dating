<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

class SendChatMessageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = User::find(1);

        $response = $this->actingAs($user)
                         ->json('POST', '/message/new', [
                             'hash' => '12345',
                             'message' => 'test message',
                         ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                 ]);
    }
}
