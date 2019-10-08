<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->words(rand(2,6), true),
        'description' => $faker->paragraph,
        'tags' => $faker->words(rand(1,4), false),
        'url' => $faker->url
    ];
});
