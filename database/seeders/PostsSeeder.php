<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $sourcePath = database_path('seeders/postImages');
        $destinationPath = storage_path('app/public/postImages');

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }
        $files = File::files($sourcePath);
        foreach ($files as $file) {
            $destination = $destinationPath . '/' . basename($file);
            File::copy($file->getPathname(), $destination);
        }

        Post::factory()->count(50)->create();
    }
}
