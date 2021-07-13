<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PortalControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function GivenData_WhenRegister_ThenReturnCreated()
    {
        $response = $this->post(
            '/api/users:register',
            [
                'email' => 'bear07111530@gmail.com',
                'password' => 123,
                'name' => 'RegisterTest',
                'dob' => '2000-04-14',
            ]
        );

        $response->assertStatus(201);
    }
}
