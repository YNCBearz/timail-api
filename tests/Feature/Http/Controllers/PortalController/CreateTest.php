<?php

namespace Tests\Feature\Http\Controllers\PortalController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group api/users:register
     * @group Web
     *
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

        $response->assertStatus(201)
            ->assertJson(
                [
                    'data' => [
                        'user' => [
                            'email' => 'bear07111530@gmail.com',
                            'name' => 'RegisterTest',
                            'dob' => '2000-04-14',
                        ],
                    ],
                ]
            );
    }

    /**
     * @group api/users:register
     * @group DataBase
     *
     * @test
     */
    public function GivenData_WhenRegister_ThenInsert()
    {
        $this->post(
            '/api/users:register',
            [
                'email' => 'bear07111530@gmail.com',
                'password' => 123,
                'name' => 'RegisterTest',
                'dob' => '2000-04-14',
            ]
        );

        /**
         * NOTE.
         * password would be hashed.
         */
        $this->assertDatabaseHas(
            'users',
            [
                'email' => 'bear07111530@gmail.com',
                'name' => 'RegisterTest',
                'dob' => '2000-04-14',
            ]
        );
    }
}
