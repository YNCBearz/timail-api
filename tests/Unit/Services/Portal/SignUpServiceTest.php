<?php

namespace Tests\Unit\Http\Controllers\Services\Portal;

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

        $this->dummy(UserRepository::class);

        Hash::spy();

        $this->sut = app(SignUpService::class);

        //Act
        $this->sut->createNewAccount($stubRequest);

        //Assert (For Facade)
        Hash::shouldHaveReceived('make')->once()->with(123);
    }

    /**
     * @test
     */
    public function GivenRequest_WhenCreateNewAccount_ThenCallRepository()
    {
        //Arrange
        $stubRequest = $this->createStub(Request::class);
        $stubRequest->email = 'bear@gmail.com';
        $stubRequest->name = 'bear';
        $stubRequest->dob = '2000-04-14';

        Hash::shouldReceive('make')
            ->andReturn(456);

        $spyUserRepository = $this->spy(UserRepository::class);

        $this->sut = app(SignUpService::class);

        //Act
        $this->sut->createNewAccount($stubRequest);

        //Assert
        $spyUserRepository
            ->shouldHaveReceived('create')
            ->once()
            ->with(
                [
                    'email' => 'bear@gmail.com',
                    'password' => 456,
                    'name' => 'bear',
                    'dob' => '2000-04-14',
                ]
            );
    }
}
