<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\Product;

$factory->define(Product::class, function (Faker $faker) {
	return [
		'name' => $faker->name,
		'slug' => $faker->unique()->slug,
		'details' => '1 icon, 2 pages , 3 headers',
		'price' => $faker->numberBetween(1599, 2999),
		'description' => $faker->text
	];
});
