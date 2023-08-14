<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Student::factory(500)->create();

        $this->call([
            RoleSeeder::class,
            KotaTurkiSeeder::class,
            AppStatusSeeder::class,
            EducationSeeder::class,
            UnivTurkiSeeder::class,
            KotaTurkiSeeder::class,
            JurusanSeeder::class,
            StatusSeeder::class,
            MyMenuSeeder::class,
            LinkSeeder::class
        ]);
    }
}
