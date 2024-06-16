<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Shoes'
        ]);
        Category::create([
            'name' => 'Jacket'
        ]);
        Category::create([
            'name' => 'Shirt'
        ]);
        Category::create([
            'name' => 'Pant'
        ]);
    }
}
