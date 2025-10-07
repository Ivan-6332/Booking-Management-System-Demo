<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone' => '1234567890',
            'address' => '123 Admin Street',
            'user_type' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create sample members
        $members = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'phone' => '1234567891',
                'address' => '456 Member Lane',
                'user_type' => 'member',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'phone' => '1234567892',
                'address' => '789 Reader Road',
                'user_type' => 'member',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'password' => Hash::make('password'),
                'phone' => '1234567893',
                'address' => '321 Book Boulevard',
                'user_type' => 'member',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($members as $member) {
            User::create($member);
        }
    }
}