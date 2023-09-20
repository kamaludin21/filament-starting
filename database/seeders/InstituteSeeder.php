<?php

namespace Database\Seeders;

use App\Models\Institute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Institute::create([
          'name' => 'dinsos',
          'slug' => 'dinsos',
          'description' => 'keterangan'
        ]);
        Institute::create([
          'name' => 'dinkes',
          'slug' => 'dinkes',
          'description' => 'keterangan'
        ]);
    }
}
