<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRegisteredUser extends Model
{
    protected $table = 'course_registered_users';

    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function registeredUser()
    {
        return $this->belongsTo(RegisteredUser::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function finalStatus()
    {
        return $this->belongsTo(FinalStatus::class);
    }

    public function activityCourseUsers()
    {
        return $this->hasMany(ActivityCourseRegisteredUser::class);
    }
}
