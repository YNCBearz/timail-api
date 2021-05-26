<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSystemUser();
    }

    protected function createSystemUser(): void
    {
        User::factory()->create(
            [
                'email' => 'system@timail.org',
                'password' => bcrypt('secret'),
                'name' => 'System',
            ]
        );
    }
}
