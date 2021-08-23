<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Bomb\Gamify\Xp::class, function (Faker $faker) {
    return [
        'name'            => $faker->text(50),
        'xp'           => $faker->randomNumber(),
        'allow_duplicate' => $faker->boolean,
    ];
});
