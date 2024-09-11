<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Expert;
use App\Models\Module;
use App\Models\Student;
use App\Models\Category;
use App\Models\Discount;
use App\Models\VideoGroup;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';
    protected $fillable = ['name','description','price','expert_id','category_id'];


    public function expert()
    {
        return $this->belongsTo(Expert::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function discount()
    {
        return $this->hasOne(Discount::class);
    }


    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrolments');
    }

    public function videogroups()
    {
        return $this->hasMany(VideoGroup::class);
    }


}
