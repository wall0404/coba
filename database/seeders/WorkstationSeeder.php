<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkstationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('workstations')->insert([
            'location_id' => '1',
            'name' => '1',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '1',
            'name' => '2',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '1',
            'name' => '3',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => '1',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => '2',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => '3',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => '4',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => '5',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => '6',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => '7',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => '8',
        ]);
    }
}
