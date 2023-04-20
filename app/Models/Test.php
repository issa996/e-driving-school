<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $fillable = ['driving_school_id'];

    public function questions(){
        return $this->hasMany(Question::class);
    }
}
