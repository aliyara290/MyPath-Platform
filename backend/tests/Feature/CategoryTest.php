<?php

use App\Models\Category;

// Helper function to generate a valid UUID for testing
function generateValidUuid() {
    return \Illuminate\Support\Str::uuid()->toString();
}

test('can list categories', function () {
    Category::factory()->count(3)->create();

    $response = $this->get('/api/categories');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        "data" => [
            "*" => [
                'name',
                'icon',
                'parent_id',
            ]
        ]
    ]);
});

test('can get a specific category', function () {
    $category = Category::factory()->create();

    $response = $this->get("/api/categories/{$category->id}");

    $response->assertStatus(200);
    $response->assertJsonStructure([
        "data" => [
            'name',
            'icon',
            'parent_id',
        ]
    ]);
});

test('can create a category', function () {
    $categoryData = [
        "name" => "cyber-security",
        "icon" => "icon",
        "parent_id" => generateValidUuid(), 
    ];

    $response = $this->post('/api/categories', $categoryData);

    $response->assertStatus(201);
    $response->assertJsonStructure([
        "data" => [
            "category" => [
                'name',
                'icon',
                'parent_id',
                'id',
            ],
            "message",
        ]
    ]);

    $this->assertDatabaseHas('categories', [
        "name" => $categoryData["name"],
        "icon" => $categoryData["icon"],
        "parent_id" => $categoryData["parent_id"],
    ]);
});

test('can update a category', function () {
    $category = Category::factory()->create();

    $updatedData = [
        "name" => "updated-name",
        "icon" => "updated-icon",
    ];

    $response = $this->put("/api/categories/{$category->id}", $updatedData);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        "data" => [
            "category" => [
                'name',
                'icon',
                'parent_id',
                'id',
            ],
            "message",
        ]
    ]);

    $this->assertDatabaseHas('categories', [
        "id" => $category->id,
        "name" => $updatedData["name"],
        "icon" => $updatedData["icon"],
    ]);
});

test('can delete a category', function () {
    $category = Category::factory()->create();

    $response = $this->delete("/api/categories/{$category->id}");

    $response->assertStatus(200);
    $response->assertJsonStructure([
        "data" => [
            "category" => [
                'name',
                'icon',
                'parent_id',
                'id',
            ],
            "message",
        ]
    ]);

    $this->assertDatabaseMissing("categories", [
        "id" => $category->id,
    ]);
});