<?php


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Storage>
 */
class StorageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(),
            'address' => $this->faker->text(),
            'phone_number' => $this->faker->text(),
            'email' => $this->faker->text(),
            'comment' => $this->faker->text()
        ];
    }
}
