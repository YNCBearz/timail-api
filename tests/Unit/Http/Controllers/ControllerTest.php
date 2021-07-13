<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
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
        $stubThrowable = $this->createStub(Throwable::class);

        Log::spy();

        $this->sut = app(Controller::class);

        //Act
        $this->sut->errorHandling($stubThrowable);

        //Assert
        Log::shouldHaveReceived('error')
            ->once()
            ->with($stubThrowable);
    }

    /**
     * @test
     */
    public function GivenThrowable_WhenErrorHandling_ThenReturnInternalServerError()
    {
        //Arrange
        $expected = Response::HTTP_INTERNAL_SERVER_ERROR;

        $stubThrowable = $this->createStub(Throwable::class);

        Log::shouldReceive('error');
        $this->sut = app(Controller::class);

        //Act
        $actual = $this->sut->errorHandling($stubThrowable);

        //Assert
        $this->assertEquals($expected, $actual->status());
    }
}
