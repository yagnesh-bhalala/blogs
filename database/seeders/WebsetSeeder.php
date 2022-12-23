<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WebsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("
        INSERT INTO `webset` (id, key_name, value, description) 
        VALUES 
        (1,	'MEMBERSHIP_MIN_AGE_YEARS',	18,	'Minimum age of applicant to become member'),
        (2,	'MEMBERSHIP_ADDRESS_CHANGE_INTERVAL_DAYS',	1,	'Minimum gap between membership address change'),
        (11, 'NEWSLETTERS_CREATE_INTERVAL_DAYS',	20,	'minimum gap between 2 items for creating'),
        (21, 'ARTICLES_CREATE_INTERVAL_DAYS', 1,	'minimum gap between 2 items for creating'),
        (31, 'EVENTS_CREATE_INTERVAL_HOURS',	1, 'minimum gap between 2 items for creating'),
        (41, 'MEDIAS_CREATE_INTERVAL_MINUTES', 15, 'minimum gap between 2 items for creating')
        ");
    }
}
