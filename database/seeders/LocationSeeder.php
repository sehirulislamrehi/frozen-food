<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("DELETE FROM locations");
        DB::table('locations')->insert([
            [
                'id' => 1,
                'name' => 'Pran',
                'type' => 'Group',
                'location_id' => null,
                'is_active' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Rfl',
                'type' => 'Group',
                'location_id' => null,
                'is_active' => 1,
            ],
        ]);
    }
}
