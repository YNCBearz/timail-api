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
    public function GivenNoneBody_WhenRegister_ThenReturnRequiredKeys()
    {
        $response = $this->postJson(
            '/api/users:register',
            [
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(
                [
                    'email',
                    'password',
                    'name',
                    'dob',
                ]
            );
    }

    /**
     * @group /api/users:register
     * @group Web
     *
     * @test
     */
    public function GivenNotRealEmails_WhenRegister_ThenReturnValidationErrors()
    {
        $response = $this->postJson(
            '/api/users:register',
            [
                'email' => 'bear@gmail.con',
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(
                [
                    'email',
                ]
            );
    }

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
            );
    }

    /**
     * @group /api/users:register
     * @group Web
     *
     * @test
     */
    public function GivenNotValidName_WhenRegister_ThenReturnValidationErrors()
    {
        $data = User::factory()->defaultUser()->make();

        $response = $this->postJson(
            '/api/users:register',
            [
                'name' => 777,
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors(
                [
                    'name',
                ]
            );
    }
}
