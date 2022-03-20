<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name',
        'roll_no',
        'photo',
        'class',
        'created_at',
    ];

    public const CLASS_SELECT = [
        '1st',
        '2nd',
        '3rd',
        '4th',
        '5th',
        '6th',
        '7th',
        '8th',
        '9th',
        '10th',
        '11th',
        '12th'
    ];

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
}
