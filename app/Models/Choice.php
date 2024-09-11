<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\QuizeItem;

class Choice extends Model
{
    use HasFactory;
    protected $table = 'choices';
    protected $fillable = ['name','quiz_item_id'];


    public function quizItem()
    {
        return $this->belongsTo(QuizeItem::class);
    }

}
