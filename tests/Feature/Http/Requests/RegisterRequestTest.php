<?php

namespace Tests\Feature\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group /api/users:register
     * @group Web
     *
     * @test
     */
    public function GivenRegisteredEmail_WhenRegisterAgain_ThenUnprocessedEntity()
    {
        $data = User::factory()->defaultUser()->create();

        $response = $this->postJson(
            '/api/users:register',
            [
                'email' => $data->email,
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(
                [
                    'email',
                ]
            );;
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
