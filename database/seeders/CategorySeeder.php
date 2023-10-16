<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Business',
                'created_at' => now(),
                'updated_at' => now()
            ], 
            [
                'name' => 'Sports',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'News',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Travel',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Food',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Lifestyle',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        $this->category->insert($categories);
    }
}
