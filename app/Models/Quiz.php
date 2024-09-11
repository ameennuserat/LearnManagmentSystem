<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VideoGroup;
use App\Models\QuizeAttempt;
use App\Models\Student;
use App\Models\QuizeItem;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizzes';
    protected $fillable = ['name','date','number_item','video_group_id'];

    public function videoGroup()
    {
        return $this->belongsTo(VideoGroup::class);
    }

    // public function quizAttempt()
    // {
    //     return $this->belongs(QuizeAttempt::class);
    // }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function quizItems()
    {
        return $this->hasMany(QuizeItem::class);
    }

}
