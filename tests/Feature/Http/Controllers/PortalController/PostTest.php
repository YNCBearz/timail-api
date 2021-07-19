<?php

namespace Tests\Feature\Http\Controllers\PortalController;

use App\Models\User;
use App\Services\Portal\SignUpService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group /api/users:register
     * @group Web
     *
     * @test
     */
    public function GivenData_WhenRegister_ThenReturnCreated()
    {
        $data = User::factory()->defaultUser()->make();

        $response = $this->postJson(
            '/api/users:register',
            [
                'email' => $data->email,
                'password' => $data->password,
                'name' => $data->name,
                'dob' => $data->dob,
            ]
        );

        $response->assertStatus(201)
            ->assertJson(
                [
                    'data' => [
                        'user' => [
                            'email' => $data->email,
                            'name' => $data->name,
                            'dob' => $data->dob,
                        ],
                    ],
                ]
            );
    }

    /**
     * @group /api/users:register
     * @group DB
     *
     * @test
     */
    public function GivenData_WhenRegister_ThenInsertData()
    {
        $data = User::factory()->defaultUser()->make();

        $this->postJson(
            '/api/users:register',
            [
                'email' => $data->email,
                'password' => $data->password,
                'name' => $data->name,
                'dob' => $data->dob,
            ]
        );

        $this->assertDatabaseHas(
            'users',
            [
                'email' => $data->email,
            ]
        );
    }

    /**
     * @group /api/users:register
     * @group Web
     *
     * @test
     */
    public function GivenRegisteredEmail_WhenRegister_ThenUnprocessedEntity()
    {
        $data = User::factory()->defaultUser()->create();

        /**
         * NOTE.
         * $data->password had been hashed.
         */
        $response = $this->postJson(
            '/api/users:register',
            [
                'email' => $data->email,
                'password' => $data->password,
                'name' => $data->name,
                'dob' => $data->dob,
            ]
        );

        $response->assertStatus(422);
    }

    /**
     * @group /api/users:register
     * @group Web
     *
     * @test
     */
    public function GivenData_WhenRegisterThrowException_ThenReturnInternalServerError()
    {
        $data = User::factory()->defaultUser()->make();

        $stubSignUpService = $this->mock(SignUpService::class);
        $stubSignUpService
            ->shouldReceive('createNewAccount')
            ->andThrow(new Exception());

        $response = $this->postJson(
            '/api/users:register',
            [
                'email' => $data->email,
                'password' => $data->password,
                'name' => $data->name,
                'dob' => $data->dob,
            ]
        );

        $response->assertStatus(500);
    }

    /**
     * @group /api/users:login
     * @group Web
     *
     * @test
     */
    public function GivenCorrectPassword_WhenLogin_ReturnOK()
    {
        $data = User::factory()->defaultUser()->create();
        $originalPassword = User::factory()::PASSWORD_DEFAULT;

        $response = $this->postJson(
            '/api/users:login',
            [
                'email' => $data->email,
                'password' => $originalPassword,
            ]
        );

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'access_token',
                    'token_type',
                    'expires_in',
                    'data' => [
                        'user',
                    ],
                ]
            );
    }

    /**
     * @group /api/users:register
     * @group Web
     *
     * @test
     */
    public function GivenEmailWithoutPassword_WhenRegister_ThenReturnUnprocessableEntity()
    {
        $data = User::factory()->defaultUser()->make();

        $response = $this->postJson(
            '/api/users:register',
            [
                'email' => $data->email,
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(
                [
                    'password',
                ]
            );
    }

}
