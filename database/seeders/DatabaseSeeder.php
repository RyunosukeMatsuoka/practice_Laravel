<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Tag;
use App\Models\Article_tag;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Tag::factory(15)->create();
        Article::factory(100)->create();
        // Article_tag::factory(15)->create();
    }
}
