<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder
{
    public function run()
    {
        // Generate 500 sample jobs
        DB::table('jobdb')->insert(
            \App\Models\Job::factory()->count(500)->make()->toArray()
        );
    }
}