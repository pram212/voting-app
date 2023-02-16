<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'phone' => '082117694669',
                'name' => 'admin',
                'email' => 'admin@example.com',
                'role' => 1,
                'password' => Hash::make('password'),
            ],
            [
                'phone' => '082117694668',
                'name' => 'saksi 1',
                'email' => 'user@example.com',
                'role' => 2,
                'password' => Hash::make('password'),
            ],
        ];

        User::insert($user);
    }
}
