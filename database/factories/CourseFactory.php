<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Course;
use Faker\Generator as Faker;
use Bezhanov\Faker\Provider\Educator as FakerEducation;

$factory->define(Course::class, function (Faker $faker) {
    return [
        //
        'text' => $faker->text(8),
    ];
});
