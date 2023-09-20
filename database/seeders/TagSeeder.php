<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::create([
          'name' => 'pemda',
          'slug' => 'pemda',
          'is_muted' => '0'
        ]);
        Tag::create([
          'name' => 'hut ri',
          'slug' => 'hut-ri',
          'is_muted' => '0'
        ]);
        Tag::create([
          'name' => 'kebakaran',
          'slug' => 'kebakaran',
          'is_muted' => '0'
        ]);
        Tag::create([
          'name' => 'pancasila',
          'slug' => 'pancasila',
          'is_muted' => '0'
        ]);
    }
}
