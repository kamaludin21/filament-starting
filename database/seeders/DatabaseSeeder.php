<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Institute;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(ArticleCategorySeeder::class);
        $this->call(InstituteSeeder::class);
        $this->call(StakeholderSeeder::class);
        $this->call(TagSeeder::class);
    }
}
