<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository
{
    /**
     * @var User $model
     */
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        $user = new $this->model;

        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->name = $data['name'];
        $user->dob = $data['dob'];

        $user->save();

        return $user;
    }
}
