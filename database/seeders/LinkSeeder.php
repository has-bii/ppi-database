<?php

namespace Database\Seeders;

use App\Models\Link;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Link::create(['my_menu_id' => 1, 'name' => 'Users', 'active' => 1, 'url' => '/my-app/admin/users', 'icon' => 'faUserGroup']);
        Link::create(['my_menu_id' => 1, 'name' => 'Students', 'active' => 1, 'url' => '/my-app/admin/database', 'icon' => 'faDatabase']);
        Link::create(['my_menu_id' => 1, 'name' => 'Forms', 'active' => 0, 'url' => '/my-app/admin/forms', 'icon' => 'faFileLines']);
        Link::create(['my_menu_id' => 2, 'name' => 'Database', 'active' => 1, 'url' => '/my-app/student/isi-database', 'icon' => 'faFilePen']);
        Link::create(['my_menu_id' => 3, 'name' => 'Daftar', 'active' => 1, 'url' => '/my-app/user/daftar-kampus', 'icon' => 'faGraduationCap']);
        Link::create(['my_menu_id' => 3, 'name' => 'Menu', 'active' => 1, 'url' => '/my-app/user/biodata', 'icon' => 'faUserPen']);
        Link::create(['my_menu_id' => 5, 'name' => 'Pendaftaran', 'active' => 1, 'url' => '/my-app/PPMB/application', 'icon' => 'faFileCirclePlus']);
        Link::create(['my_menu_id' => 5, 'name' => 'Status', 'active' => 1, 'url' => '/my-app/PPMB/status', 'icon' => 'faTag']);
        Link::create(['my_menu_id' => 5, 'name' => 'Verify', 'active' => 1, 'url' => '/my-app/PPMB/users', 'icon' => 'faUserGroup']);
        Link::create(['my_menu_id' => 4, 'name' => 'Menu', 'active' => 1, 'url' => '/my-app/su/menu', 'icon' => 'faList']);
        Link::create(['my_menu_id' => 8, 'name' => 'Roles', 'active' => 1, 'url' => '/my-app/su/roles', 'icon' => 'faUserLock']);
        Link::create(['my_menu_id' => 8, 'name' => 'Admins', 'active' => 1, 'url' => '/my-app/su/admin', 'icon' => 'faUserSecret']);
    }
}
