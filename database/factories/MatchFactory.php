<?php

use Faker\Generator as Faker;

$factory->define(App\Match::class, function (Faker $faker) {
    return [
        'user_a_id' => function () {
            return factory(App\Profile::class)->create()->user_id;
        },
        'user_b_id' => function () {
            return factory(App\Profile::class)->create()->user_id;
        }
    ];
});
// define hash and assign to user when create

// factory(App\Match::class, 10)
//     ->create()
//     ->each( function(App\Match $match){
//         $match->hash=md5($match->id);
//         $match->userA->current_match=$match->hash;
//         $match->userB->current_match=$match->hash;
//         $match->save();
//         $match->userA->save();
//         $match->userB->save();
//     });
