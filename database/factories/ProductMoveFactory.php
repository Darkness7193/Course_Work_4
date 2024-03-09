<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductMove;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<ProductMove>
 */
class ProductMoveFactory extends Factory
{
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(), //'2024-12-01',

            'product_move_type' => ProductMove::product_move_types()[random_int(0, 4)],
            'storage_id' => Storage::get()->random()->id,
            'new_storage_id' => Storage::get()->random()->id,

            'product_id' => Product::get()->random()->id,
            'quantity' => random_int(1, 1000),
            'price' => random_int(1, 1000),

            'comment' => $this->faker->text()
        ];
    }
}
