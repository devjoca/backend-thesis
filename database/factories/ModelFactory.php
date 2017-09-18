<?php

use App\Person;

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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Incident::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->safeEmail,
        'person_id' => Person::all()->pluck('id')->random(),
        'datetime' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now'),
        'lat' => $faker->latitude(-11.993841,-12.079799),
        'long' => $faker->longitude(-77.118874,-76.994591),
        'aditional_information' => $faker->text,
        'denouncePersonDetails' => $faker->text,
    ];
});


