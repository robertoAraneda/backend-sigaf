<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Http\Resources\Json\Course as JsonCourse;

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
      'properties' => [
        'id' => $this->id,
        'description'  => $this->description,
        'type'  => $this->type,
        'weighing'  => $this->weighing,
        'id_activity_moodle'  => $this->id_activity_moodle,
        'created_at' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
        'updated_at' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null
      ],
      'nestedObject' => [
        'course' => new JsonCourse($this->course)
      ],
      'collections' => [
        'activityCourseUser' => [
          'links' => [
            'href' => route('api.activities.activityCourseUser', ['id' => $this->id], false),
            'rel' => '/rels/activityCourseUser'
          ]
        ]
      ]
    ];
  }

  public function course()
  {
    return $this->belongsTo(Course::class);
  }

  public function activityCourseUsers()
  {
    return $this->hasMany(ActivityCourseRegisteredUser::class);
  }
}
