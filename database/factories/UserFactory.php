<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    const PASSWORD_DEFAULT_HASHED = '$2y$10$dxxuckFSzBx7a0qzuSjHKeQ.f1.R0YHpeTV4oaq/HV2PHqgGlEeXK';

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'dob' => '2021-06-21',
//            'email_verified_at' => now(),
            'password' => self::PASSWORD_DEFAULT_HASHED, // password
//            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * NOTE.
     * Only for test
     *
     * @return Factory
     */
    public function defaultPassword(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'password' => self::PASSWORD_DEFAULT_HASHED, // password
            ];
        });
    }
}
