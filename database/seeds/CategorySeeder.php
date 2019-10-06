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

        $categories = [];

        // insert new category
        array_push($categories, App\Category::create([
            'name' => 'sport'
        ]));

        array_push($categories, App\Category::create([
            'name' => 'programmeren'
        ]));

        array_push($categories, App\Category::create([
            'name' => 'muziek'
        ]));

        // attach categories to messages
        foreach($categories as $category) 
        {
            $randomMessages = App\Message::all()->random(100);
            $category->messages()->attach($randomMessages);
        }
    }
}
