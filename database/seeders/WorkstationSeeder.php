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
            'name' => 'Platz 1',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '1',
            'name' => 'Platz 2',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '1',
            'name' => 'Platz 3',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'Platz 1',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'Platz 2',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'Platz 3',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'Platz 4',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'Platz 5',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'Platz 6',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'Platz 7',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'Platz 8',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'Platz 9',
        ]);
        DB::table('workstations')->insert([
            'location_id' => '2',
            'name' => 'Platz 10',
        ]);
    }
}
