<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frequentlyquestions extends Model
{
    use HasFactory;
    protected $table = 'frequentlyquestions';
    protected $fillable = ['question','answer'];

}
