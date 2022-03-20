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
            'student_name' => $this->faker->name,
            'roll_no' => $this->faker->unique()->numberBetween(1000000, 99999999999),
            'photo' => 'student.jpg',
            'class' => $this->faker->randomElement(['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th']),
        ];
    }
}
