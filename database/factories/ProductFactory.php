<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\Category;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
	$id = Category::all('id')->random()->id;
    return [
        'name' => $faker->words(3, true),
        'slug' => $faker->slug(3),
        'price' => $faker->randomFloat(2, 1, 50000),
        'img' => $faker->imageUrl(),
        'description' => $faker->text(),
        'quantity' => rand(0, 10),
        'recommended' => rand(0, 1),
        'created_at' => $faker->dateTime(),
        'category_id' => $id        
    ];
});
