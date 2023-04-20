<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Driving_school extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['id','name','phone_number','address','email','password'];
    protected $hidden = ['password'];

    public function driving_students(){
        return $this->hasMany(Driving_student::class);

    }
}
