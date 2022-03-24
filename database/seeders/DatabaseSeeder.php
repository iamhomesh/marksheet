<?php

namespace Database\Seeders;

use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         \App\Models\User::factory(50)->create();
         Subject::insert([
             [
                 'name' => 'Hindi',
             ],
             [
                 'name' => 'English',
             ],
             [
                 'name' => 'Mathematics',
             ],
             [
                 'name' => 'Science',
             ],
             [
                 'name' => 'Sanskrit',
             ],
         ]);
         Student::factory(50)->create();

        $students = Student::get('id');
        $subjects = Subject::get('id');
        foreach ($students as $student){
            foreach ($subjects as $subject){
                Score::factory()->state([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                ])->create();
            }
        }
    }
}
