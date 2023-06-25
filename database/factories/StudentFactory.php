<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'student_number' => fake()->numerify('###'),
            'year' => fake()->numerify('#'),
            'address' => fake()->address(),
            'course' => 'BSIT',
        ];
    }
}
