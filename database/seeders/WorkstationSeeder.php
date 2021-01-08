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
            'name' => 'T1',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '1',
            'name' => 'T2',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '1',
            'name' => 'T3',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'C1',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'C2',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'C3',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'C4',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'C5',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'C6',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'C7',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'C8',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'C9',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'C10',
        ]);
    }
}
