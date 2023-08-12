<?php

namespace Database\Seeders;

use App\Models\KotaTurki;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KotaTurkiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KotaTurki::create(['name' => 'Bartın']);
        KotaTurki::create(['name' => 'Karabük']);
        KotaTurki::create(['name' => 'Zonguldak']);
    }
}
