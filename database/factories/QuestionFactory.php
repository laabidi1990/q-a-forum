<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'title' => rtrim($faker->sentence(rand(5, 10)), '.'), // rtrim: remove the point from the sentence
        'body' => $faker->paragraphs(rand(2, 5), true), // true: from table to paragrah with empty line between every one
        'views' => rand(0, 100),
        // 'answers_count' => rand(0, 10),
        // 'votes_count' => rand(-10, 20),
    ];
});
