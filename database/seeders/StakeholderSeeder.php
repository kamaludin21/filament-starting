<?php

namespace Database\Seeders;

use App\Models\Stakeholder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StakeholderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stakeholder::create([
          'institute_id' => 1,
          'user_id' => 1,
          'is_active' => 1,
          'level' => 'admin',
        ]);
    }
}
