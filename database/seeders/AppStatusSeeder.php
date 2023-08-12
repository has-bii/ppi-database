<?php

namespace Database\Seeders;

use App\Models\AppStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppStatus::create(['name' => 'open', 'style' => 'green']);
        AppStatus::create(['name' => 'closed', 'style' => 'red']);
    }
}
