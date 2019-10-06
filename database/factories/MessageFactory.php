<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    // add custom provider to faker by addProvider() method
    $faker->addProvider(new BlogArticleFaker\FakerProvider($faker));
    
    return [
        'title' => $faker->articleTitle,
        'content' => $faker->articleContent,
        'created_at' => $faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now', $timezone = null),
    ];
});
