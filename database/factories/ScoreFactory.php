<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Score>
 */
class ScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $studentId = Student::withCount(['scores'])->having('scores_count', '<', 5)->inRandomOrder()->first()->id;
        return [
            'student_id' => $studentId,
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'score' => $this->faker->numberBetween(0, 100),
        ];
    }
}
