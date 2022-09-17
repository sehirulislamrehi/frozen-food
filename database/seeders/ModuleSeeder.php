<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("DELETE FROM modules");
        DB::table('modules')->insert([
            [
                'id' => 1,
                'name' => 'User Module',
                'key' => 'user_module',
                'icon' => 'fas fa-users',
                'position' => 1,
                'route' => null
            ],
            [
                'id' => 2,
                'name' => 'Log Sheets',
                'key' => 'log_sheets',
                'icon' => 'fas fa-file',
                'position' => 9,
                'route' => null
            ],
            [
                'id' => 3,
                'name' => 'Location',
                'key' => 'location_module',
                'icon' => 'fas fa-map',
                'position' => 2,
                'route' => null
            ],
            [
                'id' => 4,
                'name' => 'System',
                'key' => 'system_module',
                'icon' => 'fas fa-desktop',
                'position' => 3,
                'route' => null
            ],
            [
                'id' => 5,
                'name' => 'Production',
                'key' => 'production_module',
                'icon' => 'fab fa-product-hunt',
                'position' => 4,
                'route' => null
            ],
            [
                'id' => 50,
                'name' => 'Settings',
                'key' => 'settings',
                'icon' => 'fas fa-cog',
                'position' => 10,
                'route' => null,
            ],
        ]);
    }
}