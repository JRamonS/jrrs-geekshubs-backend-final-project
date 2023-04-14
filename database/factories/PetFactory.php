<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $petType = fake()->randomElement(['Dog', 'Cat']);
        $breeds = ($petType === 'Dog') ? ['Labrador Retriever', 'German Shepherd', 'Golden Retriever'] : ['Siamese', 'Persian', 'Maine Coon', 'British Shorthair', 'Bengal'];
        return [
            'name' => fake()->firstName(),
            'age' => fake()->numberBetween(1, 15),
            'breed' => fake()->randomElement($breeds),
            'type' => $petType,
            'user_id' => User::all()->random()->id
        ];
    }
}
