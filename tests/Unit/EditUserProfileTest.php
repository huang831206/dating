<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

class EditUserProfileTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testEditUserProfile()
    {

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
                         ->json('POST', '/user/profile', [
                             'hobby' => 'test hobby',
                             'area' => 1,
                             'location' => 1,
                             'introduction' => 'test intro'
                         ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                 ]);

    }
}
