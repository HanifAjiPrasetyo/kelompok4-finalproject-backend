<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Admin',
            'username' => 'admindong',
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'is_admin' => true,
        ]);
        \App\Models\User::create([
            'name' => 'Test',
            'username' => 'testuser',
            'email' => 'user@gmail.com',
            'password' => 'password',
        ]);

        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
    }
}
