<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'username' => 'TestUser',
            'email' => 'test@example.com',
            'birthday' => date('2002-06-15'),
            'balance' => 200000,
            'password' => Hash::make('admin123'),
        ]);
    }
}
