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

    const PASSWORD_DEFAULT_HASHED = '$2y$10$z4PlHFAsy8Hao26Q72DWOu5JmUmH.sFalpPXWQ6RAA2gFWAuDOndC';
    const PASSWORD_DEFAULT = 'timail-testing';

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'birth' => '2021-06-21',
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

    /**
     * @return Factory
     */
    public function defaultUser(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Sherrinford',
                'email' => 'sherrinford@timail.org',
                'birth' => '2000-12-25',
                'password' => self::PASSWORD_DEFAULT_HASHED, // password
            ];
        });
    }
}
