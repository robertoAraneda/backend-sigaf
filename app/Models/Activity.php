<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Activity extends Model
{
  protected $table = 'activities';

  protected $guarded = [];

  public function format()
  {
    return [
      'links' => [
        'url' => route('api.activities.show', ['activity' => $this->id]),
        'href' => route('api.activities.show', ['activity' => $this->id], false),
        'rel' => 'self'
      ],
      'activity' => [
        'id' => $this->id,
        'description'  => $this->description,
        'type'  => $this->type,
        'weighing'  => $this->weighing,
        'id_activity_moodle'  => $this->id_activity_moodle,
        'course'  => $this->course,
        'created_at' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
        'updated_at' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null
      ]
    ];
  }

  public function course()
  {
    return $this->belongsTo(Course::class);
  }

  public function activityCourseRegisteredUsers()
  {
    return $this->hasMany(ActivityCourseRegisteredUser::class);
  }
}
