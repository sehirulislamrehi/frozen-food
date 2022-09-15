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
                'id' => 5,
                'key' => 'reset_password',
                'display_name' => '-- Reset Password',
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
            [
                'id' => 10,
                'key' => 'location_module',
                'display_name' => 'Location',
                'module_id' => 3,
            ],
            [
                'id' => 11,
                'key' => 'company',
                'display_name' => 'Company',
                'module_id' => 3,
            ],
            [
                'id' => 12,
                'key' => 'add_company',
                'display_name' => '-- Add Company',
                'module_id' => 3,
            ],
            [
                'id' => 13,
                'key' => 'edit_company',
                'display_name' => '-- Edit Company',
                'module_id' => 3,
            ],
            [
                'id' => 14,
                'key' => 'location',
                'display_name' => 'Location',
                'module_id' => 3,
            ],
            [
                'id' => 15,
                'key' => 'add_location',
                'display_name' => '-- Add Location',
                'module_id' => 3,
            ],
            [
                'id' => 16,
                'key' => 'edit_location',
                'display_name' => '-- Edit Location',
                'module_id' => 3,
            ],
        ]);
    }
}