<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement("DELETE FROM permissions");

        DB::table('permissions')->insert([
            [
                'id' => 1,
                'key' => 'user_module',
                'display_name' => 'User Module',
                'module_id' => 1,
            ],
            [
                'id' => 2,
                'key' => 'all_user',
                'display_name' => 'All User',
                'module_id' => 1,
            ],
            [
                'id' => 3,
                'key' => 'add_user',
                'display_name' => '-- Add User',
                'module_id' => 1,
            ],
            [
                'id' => 4,
                'key' => 'edit_user',
                'display_name' => '-- Edit User',
                'module_id' => 1,
            ],
            [
                'id' => 6,
                'key' => 'settings',
                'display_name' => 'Setting Module',
                'module_id' => 50,
            ],
            [
                'id' => 7,
                'key' => 'app_info',
                'display_name' => '-- Software Info',
                'module_id' => 50,
            ],
            [
                'id' => 8,
                'key' => 'log_sheets',
                'display_name' => 'Log sheets',
                'module_id' => 2,
            ],
            [
                'id' => 9,
                'key' => 'temperature_log',
                'display_name' => '-- Temperature log',
                'module_id' => 2,
            ],
            // [
            //     'id' => 10,
            //     'key' => 'location_module',
            //     'display_name' => 'Location',
            //     'module_id' => 3,
            // ],
            // [
            //     'id' => 11,
            //     'key' => 'company',
            //     'display_name' => 'Company',
            //     'module_id' => 3,
            // ],
            // [
            //     'id' => 12,
            //     'key' => 'add_company',
            //     'display_name' => '-- Add Company',
            //     'module_id' => 3,
            // ],
            // [
            //     'id' => 13,
            //     'key' => 'edit_company',
            //     'display_name' => '-- Edit Company',
            //     'module_id' => 3,
            // ],
            // [
            //     'id' => 14,
            //     'key' => 'location',
            //     'display_name' => 'Location',
            //     'module_id' => 3,
            // ],
            // [
            //     'id' => 15,
            //     'key' => 'add_location',
            //     'display_name' => '-- Add Location',
            //     'module_id' => 3,
            // ],
            // [
            //     'id' => 16,
            //     'key' => 'edit_location',
            //     'display_name' => '-- Edit Location',
            //     'module_id' => 3,
            // ],
            [
                'id' => 17,
                'key' => 'system_module',
                'display_name' => 'System',
                'module_id' => 4,
            ],
            [
                'id' => 18,
                'key' => 'device',
                'display_name' => 'Device',
                'module_id' => 4,
            ],
            [
                'id' => 19,
                'key' => 'add_device',
                'display_name' => '-- Add Device',
                'module_id' => 4,
            ],
            [
                'id' => 20,
                'key' => 'edit_device',
                'display_name' => '-- Edit Device',
                'module_id' => 4,
            ],
            [
                'id' => 21,
                'key' => 'delete_device',
                'display_name' => '-- Delete Device',
                'module_id' => 4,
            ],
            [
                'id' => 22,
                'key' => 'roles',
                'display_name' => 'Roles',
                'module_id' => 1,
            ],
            [
                'id' => 23,
                'key' => 'add_roles',
                'display_name' => '-- Add Roles',
                'module_id' => 1,
            ],
            [
                'id' => 24,
                'key' => 'edit_roles',
                'display_name' => '-- Edit Roles',
                'module_id' => 1,
            ],
            [
                'id' => 25,
                'key' => 'production_module',
                'display_name' => 'Production',
                'module_id' => 5,
            ],
            [
                'id' => 26,
                'key' => 'freezer',
                'display_name' => 'Freezer',
                'module_id' => 5,
            ],
            [
                'id' => 27,
                'key' => 'add_freezer',
                'display_name' => '-- Add Freezer',
                'module_id' => 5,
            ],
            [
                'id' => 28,
                'key' => 'edit_freezer',
                'display_name' => '-- Edit Freezer',
                'module_id' => 5,
            ],
            [
                'id' => 29,
                'key' => 'delete_freezer',
                'display_name' => '-- Delete Freezer',
                'module_id' => 5,
            ],
            [
                'id' => 30,
                'key' => 'database_download',
                'display_name' => 'Download Database',
                'module_id' => 6,
            ],
            [
                'id' => 31,
                'key' => 'trolley',
                'display_name' => 'Trolley',
                'module_id' => 4,
            ],
            [
                'id' => 32,
                'key' => 'add_trolley',
                'display_name' => '-- Add Trolley',
                'module_id' => 4,
            ],
            [
                'id' => 33,
                'key' => 'edit_trolley',
                'display_name' => '-- Edit Trolley',
                'module_id' => 4,
            ],
            [
                'id' => 34,
                'key' => 'products',
                'display_name' => 'Products',
                'module_id' => 4,
            ],
            [
                'id' => 35,
                'key' => 'add_products',
                'display_name' => '-- Add Products',
                'module_id' => 4,
            ],
            [
                'id' => 36,
                'key' => 'edit_products',
                'display_name' => '-- Edit Products',
                'module_id' => 4,
            ],
            [
                'id' => 37,
                'key' => 'stock_entry',
                'display_name' => '-- Stock Entry',
                'module_id' => 4,
            ],
        ]);
    }
}