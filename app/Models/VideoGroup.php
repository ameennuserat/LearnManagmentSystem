<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Video;
use App\Models\Quiz;

class VideoGroup extends Model
{
    use HasFactory;

    protected $table = 'video_groups';
    protected $fillable = ['group_name','course_id'];

    public function courses()
    {
        return $this->belongsTo(Course::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }

}
