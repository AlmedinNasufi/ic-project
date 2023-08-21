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
        $categories = ['Fiction', 'Non-Fiction', 'Fantasy', 'Mystery', 'Horror', 'Comic', 'Biography', 'Romance'];

        foreach ($categories as $key => $value) {
            Category::create([
                'name' => $value,
            ]);
        }
    }
}
