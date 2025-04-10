<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('1234567890'),
            'role' => 'admin',
        ]);

        // for ($i = 1; $i < 20; $i++) {
        //     User::factory()->create([
        //         'email' => 'user'.$i.'@example.com',
        //         'password' => bcrypt('1234567890'),
        //         'role' => 'doctor',
        //     ]);
        // }
    }
}
