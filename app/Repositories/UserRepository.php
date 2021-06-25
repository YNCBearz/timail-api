<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * @var User $model
     */
    protected User $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        $user = new User;

        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->name = $data['name'];
        $user->dob = $data['dob'];

        $user->save();

        return $user;
    }
}