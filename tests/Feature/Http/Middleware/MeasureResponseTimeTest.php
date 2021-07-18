<?php

namespace Tests\Feature\Http\Middleware;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeasureResponseTimeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        /**
         * A little weird here to define LARAVEL_START here.
         * But I found no other solution yet.
         *
         * NOTE.
         * We are sharing const LARAVEL_START in every test.
         */
        if (!defined('LARAVEL_START')) {
            define('LARAVEL_START', microtime(true));
        }
    }

    /**
     * @group Web
     *
     * @test
     */
    public function GivenRequest_WhenExcuted_ThenReturnOK()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }

    /**
     * @group Database
     *
     * @test
     */
    public function GivenRequest_WhenExcuted_ThenInsertData()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');

        $this->assertDatabaseHas(
            'request_executions',
            [
                'method' => 2,
                'path' => '/',
                'status_code' => 200,
            ]
        );
    }
}