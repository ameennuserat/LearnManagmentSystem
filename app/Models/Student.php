<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;
use App\Models\Quiz;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $fillable = ['number_courses','last_searching','user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrolments');
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class);
    }

    public function quizAttempy()
    {
        return $this->hasMany(QuizeAttempt::class);
    }

}
