<?php

namespace Database\Seeders;

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
         Student::factory(50)->create();

        $students = Student::get('id');
        foreach ($students as $student){
            Subject::factory(5)->state([
                'student_id' => $student->id,
            ])->create();
        }
    }
}
