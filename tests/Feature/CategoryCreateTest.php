<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

// use Illuminate\Foundation\Testing\WithFaker; // Not used in this test
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CategoryCreateTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;
    public function test_store_category(): void
    {

        Storage::fake('public');

        $user = User::factory()->create();
        Role::create(['name' => 'admin']);
        $user->assignRole('admin');

        $payload = [
            'name' => 'TestCategory',
            'description' => 'Test Category description',
            'image' => UploadedFile::fake()->image('test.jpg'),
        ];
        $payload['slug'] = Str::slug($payload['name']);

        $response = $this->actingAs($user)->post(route('admin.categories.store'), $payload);


        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success', 'Category created successfully');

        $this->assertDatabaseHas('categories', [
            'name' => $payload['name'],
            'description' => $payload['description'],
            'slug' => $payload['slug'],
        ]);


        $category = Category::where('name', $payload['name'])->first();
        Storage::disk('public')->assertExists('categoryImages/' . basename($category->image));
    }
}
