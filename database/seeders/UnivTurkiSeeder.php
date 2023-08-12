<?php

namespace Database\Seeders;

use App\Models\UniversitasTurki;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnivTurkiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UniversitasTurki::create(['name' => 'Bartın Üniversitesi']);
        UniversitasTurki::create(['name' => 'Karabük Üniversitesi']);
        UniversitasTurki::create(['name' => 'Zonguldak Bülent Ecevit Üniversitesi']);
    }
}
