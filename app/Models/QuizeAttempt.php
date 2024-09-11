<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Quiz;

class QuizeAttempt extends Model
{
    use HasFactory;

    protected $table = 'quize_attempts';
    protected $fillable = ['score','result','quiz_id','student_id'];

    public function students()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

}
