<?php

namespace App\Services\Login;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class SignUpService
{
    /**
     * @var UserRepository $userRepository
     */
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return User
     */
    public function createNewAccount(Request $request): User
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
            'name' => $request->name,
            'dob' => $request->dob,
        ];

        return $this->userRepository->create($data);
    }

}
