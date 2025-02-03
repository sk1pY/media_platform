<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_hidden_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrainded('users')->onDelete('cascade');
            $table->foreignId('post_id')->constrainded('posts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_hidden_posts');
    }
};
