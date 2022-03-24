<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'student_name' => 'required|string|max:255',
            'roll_no' => 'required|numeric|unique:students',
            'photo' => 'required|mimes:jpeg,png',
            'class' => ['required', 'string', Rule::in(Student::CLASS_SELECT)],
            'subjects' => 'required|array',
            'subjects.*.subject_id' => 'required|exists:subjects,id',
            'subjects.*.score' => 'required|numeric|min:0|max:100',
        ];
    }
}
