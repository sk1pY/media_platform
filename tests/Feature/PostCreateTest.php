<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PostCreateTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * A basic feature test example.
     */
    public function test_store_post(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        Role::create(['name' => 'user']);
        Permission::create(['name' => 'create_posts']);

        $user->assignRole('user');
        $user->givePermissionTo('create_posts');
        $payload = [
            'title' => 'test',
            'short_description' => 'test',
            'description' => 'test',
            'image' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => null,
            'user_id' => $user->id,
            'likes' => 0,
            'views' => 0,
            'status' => 1,
        ];

        $payload['slug'] = Str::slug($payload['title']);

        $response = $this->actingAs($user)->post(route('profile.posts.store'), $payload);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('posts', [
            'title' => $payload['title'],
            'short_description' => $payload['short_description'],
            'description' => $payload['description'],
            'category_id' => $payload['category_id'],
            'user_id' => $user->id,
            'likes' => 0,
            'views' => 0,
            'status' => 1,
        ]);

        $post = Post::where('title', $payload['title'])->first();
        Storage::disk('public')->assertExists('postImages/' . $post->image);
    }
}
