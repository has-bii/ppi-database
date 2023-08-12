<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Education::create(['name' => 'Lise']);
        Education::create(['name' => 'D3/D4']);
        Education::create(['name' => 'S1']);
        Education::create(['name' => 'S2']);
        Education::create(['name' => 'S3']);
    }
}
