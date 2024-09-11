<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;

class Expert extends Model
{
    use HasFactory;
    protected $table = 'experts';
    protected $fillable = ['image','phone','bio','user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongs(Course::class);
    }

}
