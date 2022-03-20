<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
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
        return view('create', compact('classes'));
    }

    public function store(StoreStudentRequest $request)
    {
        DB::beginTransaction();
        try {
            $fileName = time() .'.'. $request->file('photo')->extension();
            $moveLocation = '/uploads/photos/';
            $request->file('photo')->move(public_path() . $moveLocation, $fileName);
            $student = Student::create(array_merge($request->validated(), ['photo' => $moveLocation . $fileName]));
            $subjects = [];
            foreach ($request->subjects as $subject){
                $subjects[] = new Subject($subject);
            }
            $student->subjects()->saveMany($subjects);
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
        $query->with(['subjects']);
        $query->withSum('subjects', 'score');
        return datatables()->of($query)
            ->editColumn('id', function ($row) {
                return $row->id;
            })
            ->editColumn('photo', function ($row) {
                return asset($row->photo);
            })
            ->addColumn('total_score', function ($row) {
                return $row->subjects->sum('score');
            })
            ->editColumn('scores', function ($row) {
                return $row->subjects->map(fn($subject) => $subject->subject . " - " . $subject->score)->implode(', ');
            })
            ->toJson();
    }
}
