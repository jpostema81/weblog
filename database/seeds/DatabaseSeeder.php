<?php

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
        $this->call(UserTableSeeder::class);
        $this->command->info('User table seeded!');

        $this->call(BlogPostSeeder::class);
        $this->command->info('Blog posts table seeded!');
    }
}
