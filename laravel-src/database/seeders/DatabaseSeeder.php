<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(50)->create();

        \App\Models\User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'user',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        \App\Models\Tag::factory(20)->create();
        \App\Models\ListContact::factory(20)->create();

        \App\Models\Contact::factory(100)->create();
    }
}
