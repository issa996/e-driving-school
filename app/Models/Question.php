<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['id','body','image','test_id'];

    public function test(){
        return $this->belongsTo(Test::class);
    }
    public function answers(){
        return $this->hasMany(Answer::class);
    }
}
