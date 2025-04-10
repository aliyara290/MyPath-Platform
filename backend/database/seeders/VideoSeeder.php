<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            $videoCount = rand(3, 5);
            
            for ($i = 1; $i <= $videoCount; $i++) {
                Video::create([
                    'title' => "Video $i: " . $course->title,
                    'url' => "https://www.youtube.com/embed/HYKDUF8X3qI?si=h2lz3TFxfarzW5by",
                    'course_id' => $course->id,
                ]);
            }
        }
    }
}