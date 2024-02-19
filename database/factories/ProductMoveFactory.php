<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\ProductMove;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<ProductMove>
 */
class ProductMoveFactory extends Factory
{
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'product_move_type' => ['purchasing', 'selling'][random_int(0, 1)],
            'product_id' => Product::get()->random()->id,
            'quantity' => random_int(1, 1000),
            'price' => random_int(1, 1000),
            'storage_id' => Storage::get()->random()->id,
            'comment' => $this->faker->text()
        ];
    }
}
