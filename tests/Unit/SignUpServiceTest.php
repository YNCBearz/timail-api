<?php

namespace Tests\Unit;

use App\Repositories\UserRepository;
use App\Services\Portal\SignUpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SignUpServiceTest extends TestCase
{
    /**
     * @var SignUpService $sut
     */
    protected SignUpService $sut;

    /**
     * @test
     */
    public function GivenRequest_WhenCreateNewAccount_ThenHashPassword()
    {
        //Arrange
        $stubRequest = $this->createStub(Request::class);
        $stubRequest->password = 123;

        $stubUserRepository = $this->createStub(UserRepository::class);
        $this->app->instance(UserRepository::class, $stubUserRepository);

        $this->sut = $this->app->make(SignUpService::class);

        //Assert (For Facade)
        Hash::shouldReceive('make')->once()->with(123);

        //Act
        $this->sut->createNewAccount($stubRequest);
    }

}
