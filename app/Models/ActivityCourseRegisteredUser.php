<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityCourseRegisteredUser extends Model
{
  protected $table = 'activity_course_users';

  protected $guarded = [];

  public function format()
  {
    return [
      'id' => $this->id,
      'activity' => $this->activity,
      'course_registered_user' => $this->courseRegisteredUser->load('course', 'registeredUser'),
      'status_moodle' => $this->status_moodle,
      'qualification_moodle' => $this->qualification_moodle
    ];
  }

  public function courseRegisteredUser()
  {
    return $this->belongsTo(CourseRegisteredUser::class);
  }

  public function activity()
  {
    return $this->belongsTo(Activity::class);
  }
}
