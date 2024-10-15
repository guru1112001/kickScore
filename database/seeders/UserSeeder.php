<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'role_id' => rand(1, 2),
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'birthday' => now()->subYears(rand(18, 50)),
                'country_code' => '+91',
                'contact_number' => '98765432' . $i,
                'gender' => ['male', 'female'][rand(0, 1)],
                'Country_id' => rand(1, 5),
                'avatar_url' => 'avatar' . $i . '.jpg',
                'is_active' => true,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'provider_id' => Str::random(10),
                'provider' => 'google',
                'session_id' => Str::random(10),
                'fcm_token' => Str::random(20),
            ]);
        }
    }
}
