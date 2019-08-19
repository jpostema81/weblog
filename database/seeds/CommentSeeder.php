<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;
use App\Message;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get first message of first user
        $user = User::oldest()->first();
        
        $message = Message::whereNull('parent_id')->first();

        // insert new comment
        DB::table('messages')->insert([
            'title' => null,
            'content' => 'Ik vond dit een erg interessante bericht.',
            'parent_id' => $message->id,
            'author_id' => $user->id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        // insert new comment
        DB::table('messages')->insert([
            'title' => null,
            'content' => 'Ik heb een soortgelijke ervaring gehad. Leuk om te lezen.',
            'parent_id' => $message->id,
            'author_id' => $user->id,
            'created_at' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s')
        ]);
    }
}
