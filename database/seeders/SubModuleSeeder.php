<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement("DELETE FROM sub_modules");

        DB::table('sub_modules')->insert([

            //module id 1 start
            [
                'id' => 1,
                'name' => 'All User',
                'key' => 'all_user',
                'position' => 1,
                'route' => 'user.all',
                'module_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Roles',
                'key' => 'roles',
                'position' => 2,
                'route' => 'role.all',
                'module_id' => 1,
            ],
            //module id 1 end


            //module id 2 start
            [
                'id' => 4,
                'name' => 'Temperature log',
                'key' => 'temperature_log',
                'position' => 1,
                'route' => 'temperature.log',
                'module_id' => 2,
            ],
            //module id 2 end


            //module id 3 start
            [
                'id' => 5,
                'name' => 'Company',
                'key' => 'company',
                'position' => 1,
                'route' => 'company.all',
                'module_id' => 3,
            ],
            [
                'id' => 6,
                'name' => 'Location',
                'key' => 'location',
                'position' => 2,
                'route' => 'location.all',
                'module_id' => 3,
            ],
            //module id 3 end

            
            //module id 50 start
            [
                'id' => 3,
                'name' => 'App Info',
                'key' => 'app_info',
                'position' => 1,
                'route' => 'app.info.all',
                'module_id' => 50,
            ],
            //module id 50 end


            //module id 4 start
            [
                'id' => 7,
                'name' => 'Device',
                'key' => 'device',
                'position' => 1,
                'route' => 'device.all',
                'module_id' => 4,
            ],
            //module id 4 end
        
        ]);

        //last id 7
    }
}