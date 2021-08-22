<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Bomb\Gamify\Point::class, function (Faker $faker) {
    return [
        'name'            => $faker->text(50),
        'point'           => $faker->randomNumber(),
        'allow_duplicate' => $faker->boolean,
    ];
});
