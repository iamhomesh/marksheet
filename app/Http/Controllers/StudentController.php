<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function create()
    {
        $classes = Student::CLASS_SELECT;
        $subjects = Subject::get(['id', 'name']);
        return view('create', compact('classes', 'subjects'));
    }

    public function store(StoreStudentRequest $request)
    {
        DB::beginTransaction();
        try {
            $fileName = time() .'.'. $request->file('photo')->extension();
            $moveLocation = '/uploads/photos/';
            $request->file('photo')->move(public_path() . $moveLocation, $fileName);
            $student = Student::create(array_merge($request->validated(), ['photo' => $moveLocation . $fileName]));

            foreach ($request->subjects as $subject){
                Score::create([
                    'student_id' => $student->id,
                    'subject_id' => $subject['subject_id'],
                    'score' => $subject['score'],
                ]);
            }
            DB::commit();
            return response([
                'status' => true,
                'message' => 'Student added successfully..'
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return response([
               'status' => false,
               'message' => 'Something went wrong please try again.'
            ]);
        }
    }

    public function studentsDatatable()
    {
        $query = Student::query();
        $query->with(['scores']);
        $query->withSum('scores', 'score');
        return datatables()->of($query)
            ->editColumn('id', function ($row) {
                return $row->id;
            })
            ->editColumn('photo', function ($row) {
                return asset($row->photo);
            })
            ->editColumn('scores', function ($row) {
                return $row->scores->map(fn($score) => $score->score)->implode(', ');
            })
            ->toJson();
    }
}
