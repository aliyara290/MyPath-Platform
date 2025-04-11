<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programmingCategory = Category::where('name', 'Programming')->first();
        $webDevCategory = Category::where('name', 'Web Development')->first();
        $frontendCategory = Category::where('name', 'Mobile Development')->first();
        $backendCategory = Category::where('name', 'Data Science')->first();
        $mobileCategory = Category::where('name', 'Design')->first();
        $dataCategory = Category::where('name', 'Business')->first();

        $jsTag = Tag::where('name', 'JavaScript')->first();
        $reactTag = Tag::where('name', 'React')->first();
        $vueTag = Tag::where('name', 'IOS')->first();
        $laravelTag = Tag::where('name', 'Laravel')->first();
        $pythonTag = Tag::where('name', 'Python')->first();
        $phpTag = Tag::where('name', 'PostgreSQL')->first();
        $nodeTag = Tag::where('name', 'Azure')->first();
        $mobileTag = Tag::where('name', 'Mobile')->first();
        $flutterTag = Tag::where('name', 'Flutter')->first();
        $reactNativeTag = Tag::where('name', 'DevOps')->first();

        $teacher = User::first();
        $teacherId = $teacher ? $teacher->id : null;
        $courses = [
            [
                'title' => 'JavaScript Fundamentals',
                'description' => 'Learn the basics of JavaScript programming',
                'content' => 'This course covers all the fundamentals of JavaScript programming language.',
                'cover' => 'https://example.com/images/js-cover.jpg',
                'duration' => 120,
                'level' => 'beginner',
                'teacher_id' => $teacherId,
                'category_id' => $programmingCategory->id,
                'tags' => [$jsTag->id]
            ],
            [
                'title' => 'React for Beginners',
                'description' => 'Start building web applications with React',
                'content' => 'Learn how to build modern web applications using React.',
                'cover' => 'https://example.com/images/react-cover.jpg',
                'duration' => 180,
                'level' => 'beginner',
                'teacher_id' => $teacherId,
                'category_id' => $frontendCategory->id,
                'tags' => [$jsTag->id, $reactTag->id]
            ],
            [
                'title' => 'Laravel API Development',
                'description' => 'Build robust APIs with Laravel',
                'content' => 'Learn how to create RESTful APIs using Laravel framework.',
                'cover' => 'https://example.com/images/laravel-cover.jpg',
                'duration' => 240,
                'level' => 'intermediate',
                'teacher_id' => $teacherId,
                'category_id' => $backendCategory->id,
                'tags' => [$phpTag->id, $laravelTag->id]
            ],
            [
                'title' => 'Vue.js Advanced Concepts',
                'description' => 'Take your Vue.js skills to the next level',
                'content' => 'Explore advanced Vue.js concepts like vuex, custom directives, and more.',
                'cover' => 'https://example.com/images/vue-cover.jpg',
                'duration' => 300,
                'level' => 'advanced',
                'teacher_id' => $teacherId,
                'category_id' => $frontendCategory->id,
                'tags' => [$jsTag->id, $vueTag->id]
            ],
            [
                'title' => 'Python for Data Science',
                'description' => 'Learn Python for data analysis and visualization',
                'content' => 'Master Python programming for data science applications.',
                'cover' => 'https://example.com/images/python-cover.jpg',
                'duration' => 360,
                'level' => 'intermediate',
                'teacher_id' => $teacherId,
                'category_id' => $dataCategory->id,
                'tags' => [$pythonTag->id]
            ],
            [
                'title' => 'Full Stack JavaScript',
                'description' => 'Build complete applications with JavaScript',
                'content' => 'Learn to build full stack applications using JavaScript for both frontend and backend.',
                'cover' => 'https://example.com/images/fullstack-js-cover.jpg',
                'duration' => 420,
                'level' => 'advanced',
                'teacher_id' => $teacherId,
                'category_id' => $webDevCategory->id,
                'tags' => [$jsTag->id, $nodeTag->id, $reactTag->id]
            ],
            [
                'title' => 'Flutter Mobile Development',
                'description' => 'Build cross-platform mobile apps with Flutter',
                'content' => 'Learn how to develop mobile applications that work on both iOS and Android using Flutter.',
                'cover' => 'https://example.com/images/flutter-cover.jpg',
                'duration' => 300,
                'level' => 'intermediate',
                'teacher_id' => $teacherId,
                'category_id' => $mobileCategory->id,
                'tags' => [$mobileTag->id, $flutterTag->id]
            ],
            [
                'title' => 'React Native Masterclass',
                'description' => 'Create native mobile apps with React Native',
                'content' => 'Master React Native to build high-performance mobile applications.',
                'cover' => 'https://example.com/images/react-native-cover.jpg',
                'duration' => 360,
                'level' => 'advanced',
                'teacher_id' => $teacherId,
                'category_id' => $mobileCategory->id,
                'tags' => [$jsTag->id, $reactTag->id, $reactNativeTag->id, $mobileTag->id]
            ]
        ];

        foreach ($courses as $courseData) {
            $tags = $courseData['tags'];
            unset($courseData['tags']);

            $course = Course::create($courseData);
            $course->tags()->attach($tags);
        }
    }
}
