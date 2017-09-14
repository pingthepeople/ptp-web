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

/*
* User factory
*/
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'Name' => $faker->name,
        'Email' => $faker->unique()->safeEmail,
        'remember_token' => str_random(10),
    ];
});

/*
* Action factory
* for past actions
*/
$factory->define(App\Action::class, function(Faker\Generator $faker) {
    $bill = Bill::inRandomOrder()->first();
    return [
        'Link' => '/bill-actions/s_list_bill.'.$faker->numberBetween(1500000,2700000),
        'Description' => $faker->words(rand(4,6), true),
        'Date' => $faker->date('Y-m-d h:m:s.000'),
        'Chamber' => $bill->Chamber,
        'ActionType' => $faker->numberBetween(0, 4),
        'BillId' => $bill->Id
    ];
});

/*
* ScheduledAction factory
* for future actions
*/
$factory->define(App\ScheduledAction::class, function(Faker\Generator $faker) {
    $bill = Bill::inRandomOrder()->first();
    return [
        'Link' => '/bill-scheduled-action/s_list_bill.'.$faker->numberBetween(1500000,2700000),
        'Date' => $faker->date('Y-m-d h:m:s.000'),
        'Start' => $faker->time(),
        'End' => $faker->time(),
        'Location' => "Room ".rand(100,800),
        'Chamber' => $bill->Chamber,
        'ActionType' => $faker->numberBetween(0, 4),
        'BillId' => $bill->Id
    ];
});

/*
* Bill factory
*/
$factory->define(App\Bill::class, function(Faker\Generator $faker) {
    $session = Session::inRandomOrder()->first();
    if(!$session) {
        factory('App\Session')->create();
        $session = Session::first();
    }

    $chamber = $faker->numberBetween(1,2);
    $name = ($chamber==1?'HB':'SB').$faker->numberBetween(1000,9999);
    return [
        'Name' => $name,
        'Link' => "/".$session->Name."/bills/".$name,
        'Title' => $faker->words($faker->numberBetween(2,4), true),
        'Description' => $faker->sentences($faker->numberBetween(2,40), true),
        'Chamber' => $chamber,
        'SessionId' => $session->Id,
    ];
});

/*
* Legislator factory
*/
$factory->define(App\Legislator::class, function(Faker\Generator $faker) {
    $session = App\Session::inRandomOrder()->first();
    return [
        'FirstName' => $faker->FirstName,
        'LastNAme' => $faker->LastName,
        'Chamber' => $faker->numberBetween(1,2),
        'Party' => $faker->numberBetween(1,2),
        'District' => $faker->numberBetween(1,40),
        'Link' => $faker->url,
        'Image' => $faker->ImageUrl,
        'SessionId' => $session->Id
    ];
});

/*
* Committee factory
*/
$factory->define(App\Committee::class, function(Faker\Generator $faker) {
    $session = Session::first();
    if(!$session) {
        factory('App\Session')->create();
        $session = Session::first();
    }

    return [
        'Name' => 'Committee for '.$faker->words(5, true),
        'Link' => $faker->url,
        'Chamber' => $faker->numberBetween(1,2),
        'SessionId' => $session->Id,
    ];
});

/*
* Session factory
*/
$factory->define(App\Session::class, function(Faker\Generator $faker) {
    $now = \Carbon\Carbon::now();
    $currentSession = Session::where('Name', $now->year)->first();
    if(!$currentSession) {
        $year = $now->year;
    } else {
        $year = $faker->year;
    }

    return [
        'Name' => "$year",
        'Link' => "/$year",
    ];
});

/*
* Subject factory
*/
$factory->define(App\Subject::class, function(Faker\Generator $faker) {
    $session = Session::first();
    if(!$session) {
        factory('App\Session')->create();
        $session = Session::first();
    }

    return [
        'Name' => strtoupper($faker->words(2,true)),
        'Link' => $faker->url,
        'SessionId' => $session->Id,
    ];
});
