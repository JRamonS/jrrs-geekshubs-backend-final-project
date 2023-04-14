<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'observation' => fake()->sentence(),
            'date/time' => fake()->dateTime(),
            'user_id' => User::all()->random()->id,
            'service_id' => Service::all()->random()->id,
            'pet_id' => Pet::all()->random()->id
        ];
    }
}
