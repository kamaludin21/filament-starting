<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ArticleCategory::create([
          'name' => 'politik dan pemerintahan',
          'slug' => 'politik-dan-pemerintahan',
        ]);
        ArticleCategory::create([
          'name' => 'sosial dan budaya',
          'slug' => 'sosial-dan-budaya',
        ]);
        ArticleCategory::create([
          'name' => 'pendidikan dan teknologi',
          'slug' => 'pendidikan-dan-teknologi',
        ]);
        ArticleCategory::create([
          'name' => 'olahraga',
          'slug' => 'olahraga',
        ]);
        ArticleCategory::create([
          'name' => 'lingkungan dan kesehatan',
          'slug' => 'lingkungan-dan-kesehatan',
        ]);
        ArticleCategory::create([
          'name' => 'transportasi',
          'slug' => 'transportasi',
        ]);
        ArticleCategory::create([
          'name' => 'religi',
          'slug' => 'religi',
        ]);
    }
}
