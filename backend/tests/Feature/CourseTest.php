<?php

use App\Models\Course;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

uses(RefreshDatabase::class);

function generateValidUuid()
{
    return \Illuminate\Support\Str::uuid()->toString();
}

test('can list courses', function () {
    $category = Category::factory()->create();

    $course = Course::factory()->create([
        'category_id' => $category->id,
        'teacher_id' => "ghzsdc-746327",
    ]);
    $tag = Tag::factory()->create();
    $course->tags()->attach($tag->id);

    $response = $this->get('/api/courses');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'courses' => [
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'content',
                    'video',
                    'cover',
                    'duration',
                    'level',
                    'category_id',
                    'teacher_id',
                    'tags',
                ]
            ]
        ]
    ]);
});

test('can get a specific course', function () {
    $category = Category::factory()->create();

    $course = Course::factory()->create([
        'category_id' => $category->id,
        'teacher_id' => "ghzsdc-746327",
    ]);

    $response = $this->get("/api/courses/{$course->id}");

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            'id',
            'title',
            'description',
            'content',
            'video',
            'cover',
            'duration',
            'level',
            'category_id',
            'teacher_id',
            'tags',
        ]
    ]);
});

test('can create a course', function () {
    $category = Category::factory()->create();

    $tag = Tag::factory()->create();

    $courseData = [
        'title' => 'Test Course',
        'description' => 'This is a test course.',
        'content' => 'Test content',
        'video' => 'test-video.mp4',
        'cover' => 'test-cover.jpg',
        'duration' => 60,
        'level' => 'beginner',
        'teacherId' => "ghzsdc-746327",
        'categoryId' => $category->id,
        'tags' => [$tag->id],
    ];

    $response = $this->post('/api/courses', $courseData);

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'data' => [
            'course' => [
                'id',
                'title',
                'description',
                'content',
                'video',
                'cover',
                'duration',
                'level',
                'category_id',
                'teacher_id',
            ],
            'message',
        ]
    ]);

    $this->assertDatabaseHas('courses', [
        'title' => $courseData['title'],
        'description' => $courseData['description'],
        'category_id' => $courseData['categoryId'],
        'teacher_id' => $courseData['teacherId'],
    ]);

    $course = Course::first();
    $this->assertCount(1, $course->tags);
});

test('can update a course', function () {
    $category = Category::factory()->create();

    $course = Course::factory()->create([
        'category_id' => $category->id,
        'teacher_id' => "ghzsdc-746327",
    ]);
    $tag = Tag::factory()->create();
    $course->tags()->attach($tag->id);

    $updatedData = [
        'title' => 'Updated Course Title',
        'description' => 'Updated course description.',
        'content' => 'Updated content',
        'video' => 'updated-video.mp4',
        'cover' => 'updated-cover.jpg',
        'duration' => 90,
        'level' => 'intermediate',
        'teacherId' => "ghzsdc-746327",
        'categoryId' => $category->id,
        'tags' => [$tag->id],
    ];

    $response = $this->put("/api/courses/{$course->id}", $updatedData);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            'course' => [
                'id',
                'title',
                'description',
                'content',
                'video',
                'cover',
                'duration',
                'level',
                'category_id',
                'teacher_id',
            ],
            'message',
        ]
    ]);

    $this->assertDatabaseHas('courses', [
        'id' => $course->id,
        'title' => $updatedData['title'],
        'description' => $updatedData['description'],
    ]);

    $course->refresh();
    $this->assertCount(1, $course->tags);
});

test('can delete a course', function () {
    $category = Category::factory()->create();

    $course = Course::factory()->create([
        'category_id' => $category->id,
        'teacher_id' => "ghzsdc-746327",
    ]);

    $response = $this->delete("/api/courses/{$course->id}");

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            'message',
        ]
    ]);

    $this->assertDatabaseMissing('courses', [
        'id' => $course->id,
    ]);
});
