<?php

namespace Tests\Feature;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Throwable;

class ControllerTest extends TestCase
{
    /**
     * @var Controller $sut
     */
    protected Controller $sut;

    /**
     * @test
     */
    public function GivenThrowable_WhenErrorHandling_ThenCallLogFacade()
    {
        //Arrange
        Log::spy();
        $stubThrowable = $this->createStub(Throwable::class);

        $this->sut = app(Controller::class);

        //Act
        $this->sut->errorHandling($stubThrowable);

        //Assert
        Log::shouldHaveReceived('error')
            ->once()
            ->with($stubThrowable);
    }
}
