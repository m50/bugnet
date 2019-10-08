<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Error;
use Faker\Generator as Faker;

$factory->define(Error::class, function (Faker $faker) {
    $a = ['low', 'medium', 'high', 'critical'];
    $path = "{$faker->word}/{$faker->word}/{$faker->word}";
    $jsonStep = [
        "file" => "/usr/local/www/laravel/$path.{$faker->fileExtension}",
        "line" => rand(1, 500),
        "function" => "abort",
        "class" => str_replace('/', '\\', $path),
        "type" => "->",
        "args" => [
            $faker->word
        ]
    ];
    $path2 = "{$faker->word}/{$faker->word}/{$faker->word}";
    $jsonStep2 = [
        "file" => "/usr/local/www/laravel/$path2.{$faker->fileExtension}",
        "line" => rand(1, 500),
        "function" => "abort",
        "class" => str_replace('/', '\\', $path2),
        "type" => "->",
        "args" => [
            $faker->word
        ]
    ];
    $path3 = "{$faker->word}/{$faker->word}/{$faker->word}";
    $jsonStep3 = [
        "file" => "/usr/local/www/laravel/$path3.{$faker->fileExtension}",
        "line" => rand(1, 500),
        "function" => "abort",
        "class" => str_replace('/', '\\', $path3),
        "type" => "->",
        "args" => [
            $faker->word
        ]
    ];
    return [
        'exception' => $faker->name,
        'importance' => $a[rand(0,3)],
        'trace' => [
            $jsonStep,
            $jsonStep2,
            $jsonStep3
        ]
    ];
});
