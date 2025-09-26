<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Facility>
 */
class FacilityFactory extends Factory
{
    protected $model = Facility::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'address_id' => Address::factory(),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'equipment' => $this->faker->words(3, true),
            'description' => $this->faker->sentence,
        ];
    }
}
