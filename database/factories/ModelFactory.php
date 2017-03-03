<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Session;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'Name' => $faker->name,
        'Email' => $faker->unique()->safeEmail,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Action::class, function(Faker\Generator $faker) {
    return [
        'Link' => $faker->url,
        'Description' => $faker->sentences(2, true),
        'Date' => $faker->date('Y-m-d'),
        'Chamber' => $faker->numberBetween(1,2),
        'ActionType' => $faker->numberBetween(0, 4),
    ];
});

$factory->define(App\Bill::class, function(Faker\Generator $faker) {
    return [
        'Name' => 'XB-'.$faker->numberBetween(100,999),
        'Link' => $faker->url,
        'Title' => $faker->sentence,
        'Description' => $faker->sentences(3, true),
        'Authors' => $faker->name,
        'Chamber' => $faker->numberBetween(1,2),
        'SessionId' => $faker->randomElement(Session::all()->map(function($s){
            return $s->Id;
        })->toArray()),
    ];
});

$factory->define(App\Committee::class, function(Faker\Generator $faker) {
    return [
        'Name' => $faker->sentence,
        'Link' => $faker->url,
        'Chamber' => $faker->numberBetween(1,2),
        'SessionId' => $faker->randomElements(Session::all()->lists('Id')),
    ];
});

$factory->define(App\Session::class, function(Faker\Generator $faker) {
    return [
        'Name' => 'Session '.$faker->sentence,
        'Link' => $faker->url,
    ];
});

$factory->define(App\Subject::class, function(Faker\Generator $faker) {
    return [
        'Name' => $faker->words(2),
        'Link' => $faker->url,
        'SessionId' => $faker->randomElements(Session::all()->lists('Id')),
    ];
});
