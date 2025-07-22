<?php

namespace Database\Seeders;

use App\Models\Subscribe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscribesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Subscribe::factory()->count(100)->create();
    }
}
