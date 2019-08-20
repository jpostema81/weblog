<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // delete all existing categories first
        DB::table('categories')->delete();

        // insert new category
        $message_id = DB::table('categories')->insertGetId([
            'name' => 'sport'
        ]);

        // insert new category
        $message_id = DB::table('categories')->insertGetId([
            'name' => 'programmeren'
        ]);

        // insert new category
        $message_id = DB::table('categories')->insertGetId([
            'name' => 'muziek'
        ]);

        // insert new category
        $message_id = DB::table('categories')->insertGetId([
            'name' => 'overig'
        ]);
    }
}
