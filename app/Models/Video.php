<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VideoGroup;
class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';
    protected $fillable = ['title','description','time','url','video_group_id'];

    public function videogroups()
    {
        return $this->belongsTo(VideoGroup::class);
    }
}
