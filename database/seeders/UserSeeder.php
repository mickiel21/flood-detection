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
                'email' => 'miguelitscastejon04@gmail.com',
                'password' => 'password',
                'phone' => '639919836346',
                'role' => 'admin',
            ],
            [
                'name' => 'authority',
                'email' => 'symon0717cruz@gmail.com',
                'password' => 'password',
                'phone' => '639761602021',
                'role' => 'authority',
            ],

            [
                'name' => 'public',
                'email' => 'anesmarkhero@gmail.com',
                'password' => 'password',
                'phone' => '639197613741',
                'role' => 'public',
            ]
        ];

        foreach($users as $user) {
            $created_user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'password' => Hash::make($user['password']),
            ]);

            $created_user->assignRole($user['role']);
        }
    }
}
