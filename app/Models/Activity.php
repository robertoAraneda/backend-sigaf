<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Activity extends Model
{
  protected $table = 'activities';

  protected $guarded = [];

  public function course()
  {
    return $this->belongsTo(Course::class);
  }

  public function activityCourseRegisteredUsers()
  {
    return $this->hasMany(ActivityCourseRegisteredUser::class);
  }
}
