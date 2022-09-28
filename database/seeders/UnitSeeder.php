<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement("DELETE FROM units");
        DB::table("units")->insert([
            [
                'id' => 1,
                'name' => 'gm',
                'is_active' => true,
            ],
        ]);
        
    }
}
