<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return StudentResource::collection(Student::withSum('scores', 'score')->orderByDesc('scores_sum_score')->get());
    }
}
