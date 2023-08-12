<?php

namespace Database\Seeders;

use App\Models\MyMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MyMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MyMenu::create(['label' => 'Admin', 'role_id' => 1, 'active' => 1]);
        MyMenu::create(['label' => 'Student', 'role_id' => 2, 'active' => 1]);
        MyMenu::create(['label' => 'User', 'role_id' => 3, 'active' => 1]);
        MyMenu::create(['label' => 'Super User', 'role_id' => 4, 'active' => 1]);
        MyMenu::create(['label' => 'PPMB', 'role_id' => 5, 'active' => 1]);
        MyMenu::create(['label' => 'Sekretaris', 'role_id' => 6, 'active' => 1]);
        MyMenu::create(['label' => 'Bendahara', 'role_id' => 7, 'active' => 1]);
        MyMenu::create(['label' => 'Users', 'role_id' => 4, 'active' => 1]);
    }
}
