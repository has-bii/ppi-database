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
        AppStatus::create(['name' => 'verified', 'style' => 'green']);
        AppStatus::create(['name' => 'checking', 'style' => 'sky']);
        AppStatus::create(['name' => 'interview', 'style' => 'yellow']);
        AppStatus::create(['name' => 'accepted', 'style' => 'green']);
        AppStatus::create(['name' => 'declined', 'style' => 'red']);
        AppStatus::create(['name' => 'missing', 'style' => 'red']);
    }
}
