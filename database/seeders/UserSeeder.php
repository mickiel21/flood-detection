<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'mickieloraa21@gmail.com',
                'password' => 'password',
                'role' => 'admin',
            ],
            [
                'name' => 'authority',
                'email' => 'jmcastejon04@gmail.com',
                'password' => 'password',
                'role' => 'authority',
            ],

            [
                'name' => 'public',
                'email' => 'hero21@gmail.com',
                'password' => 'password',
                'role' => 'public',
            ]
        ];

        foreach($users as $user) {
            $created_user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
            ]);

            $created_user->assignRole($user['role']);
        }
    }
}
