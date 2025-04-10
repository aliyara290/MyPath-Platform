<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Programming',
                'icon' => 'code',
                'parent_id' => null
            ],
            [
                'name' => 'Web Development',
                'icon' => 'globe',
                'parent_id' => null
            ],
            [
                'name' => 'Mobile Development',
                'icon' => 'smartphone',
                'parent_id' => null
            ],
            [
                'name' => 'Data Science',
                'icon' => 'chart-bar',
                'parent_id' => null
            ],
            [
                'name' => 'Design',
                'icon' => 'paint-brush',
                'parent_id' => null
            ],
            [
                'name' => 'Business',
                'icon' => 'briefcase',
                'parent_id' => null
            ],
            [
                'name' => 'Photography',
                'icon' => 'camera',
                'parent_id' => null
            ],
            [
                'name' => 'Music',
                'icon' => 'music',
                'parent_id' => null
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create some subcategories
        $webDevelopment = Category::where('name', 'Web Development')->first();
        if ($webDevelopment) {
            Category::create([
                'name' => 'Frontend',
                'icon' => 'code',
                'parent_id' => $webDevelopment->id
            ]);
            
            Category::create([
                'name' => 'Backend',
                'icon' => 'server',
                'parent_id' => $webDevelopment->id
            ]);
            
            Category::create([
                'name' => 'Full Stack',
                'icon' => 'layers',
                'parent_id' => $webDevelopment->id
            ]);
        }
    }
}