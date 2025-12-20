<?php

namespace Database\Factories;

use App\Models\Facility;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'facility_id' => Facility::factory(),
            'title' => $this->faker->sentence,
            'start_datetime' => Carbon::instance($this->faker->dateTimeBetween('-1 year', '+1 year')),
        ];
    }
}
