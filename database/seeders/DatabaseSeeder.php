<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(1000)->create();

        // Student::factory(500)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(RoleSeeder::class);
        $this->call(KotaTurkiSeeder::class);
        $this->call(AppStatusSeeder::class);
        $this->call(EducationSeeder::class);
        $this->call(UnivTurkiSeeder::class);
        $this->call(KotaTurkiSeeder::class);
        $this->call(JurusanSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(MyMenuSeeder::class);
        $this->call(LinkSeeder::class);
    }
}
