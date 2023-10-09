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
      'name' => 'Politik dan Pemerintahan',
      'slug' => 'politik-dan-pemerintahan',
    ]);
    ArticleCategory::create([
      'name' => 'Sosial dan Budaya',
      'slug' => 'sosial-dan-budaya',
    ]);
    ArticleCategory::create([
      'name' => 'Pendidikan dan Teknologi',
      'slug' => 'pendidikan-dan-teknologi',
    ]);
    ArticleCategory::create([
      'name' => 'Olahraga',
      'slug' => 'olahraga',
    ]);
    ArticleCategory::create([
      'name' => 'Lingkungan dan Kesehatan',
      'slug' => 'lingkungan-dan-kesehatan',
    ]);
    ArticleCategory::create([
      'name' => 'Transportasi',
      'slug' => 'transportasi',
    ]);
    ArticleCategory::create([
      'name' => 'Religi',
      'slug' => 'religi',
    ]);
  }
}
