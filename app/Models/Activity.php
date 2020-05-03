<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Http\Resources\Json\Course as JsonCourse;

class Activity extends Model
{
  protected $table = 'activities';

  protected $guarded = [];

  /**
   * Get the activity formated
   *
   * @return array
   */
  public function format()
  {
    return [
      'links' => [
        'href' => route('api.activities.show', ['activity' => $this->id], false),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'description'  => $this->description,
        'type'  => $this->type,
        'weighing'  => $this->weighing,
        'idActivityMoodle'  => $this->id_activity_moodle,
        'createdAt' => $this->created_at != null
          ?  Carbon::parse($this->created_at)->format('d-m-Y')
          : null,
        'updatedAt' => $this->updated_at != null
          ?  Carbon::parse($this->updated_at)->format('d-m-Y')
          : null
      ],
      'nestedObjects' => [
        'course' => new JsonCourse($this->course)
      ],
      'relationships' => [
        'activityCourseUser' => [
          'numberOfElements' => $this->activityCourseUsers()->count(),
          'links' => [
            'href' => route('api.activities.activityCourseUsers', ['activity' => $this->id], false),
            'rel' => '/rels/activityCourseUser'
          ]
        ]
      ]
    ];
  }

  /**
   * Get the course for the activity
   *
   */
  public function course()
  {
    return $this->belongsTo(Course::class);
  }

  /**
   * Get a list of activities for the course for a the specific user
   *
   */
  public function activityCourseUsers()
  {
    return $this->hasMany(ActivityCourseRegisteredUser::class);
  }
}
