<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Student']);
        Role::create(['name' => 'User']);
        Role::create(['name' => 'Super User']);
        Role::create(['name' => 'PPMB']);
        Role::create(['name' => 'Sekretaris']);
        Role::create(['name' => 'Bendahara']);
    }
}
