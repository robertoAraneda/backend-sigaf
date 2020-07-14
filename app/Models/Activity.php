<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Http\Resources\Json\Course as JsonCourse;
use App\Http\Resources\Json\Section as JsonSection;

class Activity extends Model
{
  protected $table = 'activities';

  protected $fillable = ['section_id', 'weighing'];

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
        'course' => new JsonCourse($this->course),
        'section' => $this->section != null
          ? new JsonSection($this->section)
          : ["links" => null, "properties" => ["id" => "", "description" => ""]],
        'createdAt' => $this->created_at != null
          ?  Carbon::parse($this->created_at)->format('d-m-Y')
          : null,
        'updatedAt' => $this->updated_at != null
          ?  Carbon::parse($this->updated_at)->format('d-m-Y')
          : null
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
   * Get the section for the activity
   *
   */
  public function section()
  {
    return $this->belongsTo(Section::class);
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
