<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Message;

class CategoryMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // delete all existing pivot entries first
        DB::table('category_message')->delete();

        // get first message
        $message = Message::whereNull('parent_id')->first();
        $categories = Category::all()->take(2);

        foreach($categories as $category) {
            // insert new posts
            DB::table('category_message')->insert([
                'category_id' => $category->id,
                'message_id' => $message->id,
            ]);
        }
    }
}
