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
     * @dataProvider notValidRequest
     *
     * @test
     */
    public function GivenNotValidRequest_WhenRegister_ThenValidationErrors(array $data, array $errors)
    {
        $response = $this->postJson(
            '/api/users:register',
            $data
        );

        $response->assertJsonValidationErrors(
            $errors
        );
    }

    /**
     * @return array
     */
    public function notValidRequest(): array
    {
        return [
            /**
             * required
             */
            [[], ['email']],
            [[], ['password']],
            [[], ['name']],
            [[], ['dob']],

            /**
             * email
             */
            [['email' => 'bear@gmail.con'], ['email']],
            [['email' => 'bear@gmail'], ['email']],

            /**
             * name
             */
            [['name' => 123], ['name']],
            [['dob' => 123], ['dob']],
        ];
    }

    /**
     * @group /api/users:register
     * @group Web
     *
     * @dataProvider validRequest
     *
     * @test
     */
    public function GivenValidRequest_WhenRegister_ThenMissingValidationErrors(array $data, array $keys)
    {
        $response = $this->postJson(
            '/api/users:register',
            $data
        );

        $response->assertJsonMissingValidationErrors(
            $keys
        );
    }

    /**
     * @return array
     */
    public function validRequest(): array
    {
        return [
            /**
             * email
             */
            [['email' => 'bear@gmail.com'], ['email']],

            /**
             * name
             */
            [['name' => 'bear'], ['name']],

            /**
             * dob
             */
            [['dob' => '2020-04-14'], ['dob']],
        ];
    }
}
