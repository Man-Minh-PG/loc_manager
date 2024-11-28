<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\IndexKey::factory(3)->create();
        \App\Models\ParentTaskLoc::factory(23)->create();
        \App\Models\ChildTaskLoc::factory(46)->create();
    }
}
