<?php


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(),
            'manufactor' => $this->faker->text(),
            'purchase_price' => random_int(1, 1000),
            'selling_price' => random_int(1, 1000),
            'comment' => $this->faker->text()
        ];
    }
}
