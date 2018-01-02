<?php

use Faker\Generator as Faker;

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create([
                'is_profile_complete' => true,
            ])->id;
        },
        'hobby' => $faker->sentence,
        'introduction' => $faker->sentence,
        'location_id' => $faker->numberBetween(1, 22),
        'research_area_id' => $faker->numberBetween(1, 21),
        'gender' => $faker->randomElement(['boy', 'girl'])
    ];
});
