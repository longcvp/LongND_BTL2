<?php

use App\Models\User;
use App\Models\Information;
use App\Models\Wallet;
use App\Models\Category;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'username' => $faker->word,
        'email' => $faker->unique->freeEmail,
        'active' => ACTIVE,
        'reset_password' => NO_RESET_PASS,
        'password' => bcrypt('123456'), // password
    ];
});

$factory->define(Information::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->e164PhoneNumber,
        'avatar' => 'images/avatar/default.JPG',
        'address' => $faker->address,
        'gender' => $faker->numberBetween($min = 1, $max = 2),
        'birthday' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'user_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
    ];
});


$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'code' => bcrypt('123456'),
        'reset_code' => NO_RESET_PASS,
        'ssid' => '1000'.(string)$faker->numberBetween($min = 10000000, $max = 99999999),
        'money' => '100000000',
        'user_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
    ];
});


$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_id' => $faker->numberBetween($min = 1, $max = 3),
        'type' => $faker->numberBetween($min = 1, $max = 2),
        'parent_id' => $faker->numberBetween($min = 1, $max = 6),
    ];
});

