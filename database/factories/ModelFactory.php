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
use App\Bill;
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
    $bill = Bill::withoutGlobalScope(\App\Scopes\CurrentSessionScope::class)->inRandomOrder()->first();
    return [
        'Link' => '/bill-actions/s_list_bill.'.$faker->numberBetween(1500000,2700000),
        'Description' => $faker->sentences(2, true),
        'Date' => $faker->date('Y-m-d h:m:s.000'),
        'Chamber' => $faker->numberBetween(1,2),
        'ActionType' => $faker->numberBetween(0, 4),
        'BillId' => $bill->Id
    ];
});

$factory->define(App\Bill::class, function(Faker\Generator $faker) {
    $session = Session::inRandomOrder()->first();
    $name = 'XB'.$faker->numberBetween(1000,9999);
    return [
        'Name' => $name,
        'Link' => "/".$session->Name."/bills/".$name,
        'Title' => $faker->words($faker->numberBetween(2,4), true),
        'Description' => $faker->sentences($faker->numberBetween(2,40), true),
        'Authors' => strtolower($faker->lastName),
        'Chamber' => $faker->numberBetween(1,2),
        'SessionId' => $session->Id,
    ];
});

$factory->define(App\Committee::class, function(Faker\Generator $faker) {
    $session = Session::inRandomOrder()->first();
    return [
        'Name' => 'Committee for '.$faker->words(5, true),
        'Link' => $faker->url,
        'Chamber' => $faker->numberBetween(1,2),
        'SessionId' => $session->Id,
    ];
});

$factory->define(App\Session::class, function(Faker\Generator $faker) {
    $year = $faker->year;
    return [
        'Name' => "$year",
        'Link' => "/$year",
    ];
});

$factory->define(App\Subject::class, function(Faker\Generator $faker) {
    $session = Session::inRandomOrder()->first();
    return [
        'Name' => strtoupper($faker->words(2,true)),
        'Link' => $faker->url,
        'SessionId' => $session->Id,
    ];
});
