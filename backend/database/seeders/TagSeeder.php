<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'JavaScript'],
            ['name' => 'PHP'],
            ['name' => 'Python'],
            ['name' => 'React'],
            ['name' => 'Vue'],
            ['name' => 'Angular'],
            ['name' => 'Laravel'],
            ['name' => 'Django'],
            ['name' => 'Node.js'],
            ['name' => 'Express'],
            ['name' => 'MongoDB'],
            ['name' => 'MySQL'],
            ['name' => 'PostgreSQL'],
            ['name' => 'Docker'],
            ['name' => 'AWS'],
            ['name' => 'Google Cloud'],
            ['name' => 'Azure'],
            ['name' => 'DevOps'],
            ['name' => 'CI/CD'],
            ['name' => 'Testing'],
            ['name' => 'Mobile'],
            ['name' => 'iOS'],
            ['name' => 'Android'],
            ['name' => 'Flutter'],
            ['name' => 'React Native']
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}