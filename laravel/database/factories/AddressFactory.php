<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Municipality;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    protected $model = Address::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'municipality_id' => Municipality::factory(), // 自動で市区町村も作る
            'postal_code' => $this->faker->numerify('#######'),
            'town' => $this->faker->city,
            'chome' => $this->faker->buildingNumber,
            'banchi' => $this->faker->buildingNumber,
            'go' => null,
            'building' => $this->faker->streetName,
            'room' => null,
        ];
    }
}
