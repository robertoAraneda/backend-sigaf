<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;


class RegisteredUser extends Model
{

    protected $table = 'registered_users';

    protected $guarded = [];

    public function createdUser(){
        return $this->belongsTo(User::class);
    }

    public function updatedUser(){
        return $this->belongsTo(User::class);
    }

    public function courseRegisteredUsers(){
        return $this->hasMany(CourseRegisteredUser::class);
    }
}
