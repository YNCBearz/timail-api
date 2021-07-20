<?php

namespace Tests\Feature\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group /api/users:login
     * @group Web
     *
     * @test
     */
    public function GivenNotExistedUser_WhenLogin_ThenReturnUnauthorized()
    {
        $response = $this->postJson(
            '/api/users:login',
            [
                'email' => 'notExistUser@gmail.com',
                'password' => 123,
            ]
        );

        $response->assertStatus(401);
    }
}
