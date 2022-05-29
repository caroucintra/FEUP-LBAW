<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'resources/sql/schema.sql';
        $path2 = 'resources/sql/triggers.sql';
        $path3 = 'resources/sql/population.sql';
        DB::unprepared(file_get_contents($path));
        DB::unprepared(file_get_contents($path2));
        DB::unprepared(file_get_contents($path3));
        $this->command->info('Database seeded!');
    }
}
