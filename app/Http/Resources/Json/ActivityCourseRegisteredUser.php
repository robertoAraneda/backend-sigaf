<?php

namespace App\Http\Resources\Json;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityCourseRegisteredUser extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'links' => [
        'url' => route('api.activityCourseRegisteredUsers.show', ['activityCourseRegisteredUser' => $this->id]),
        'href' => route('api.activityCourseRegisteredUsers.show', ['activityCourseRegisteredUser' => $this->id], false),
        'rel' => 'self'
      ],
      'id' => $this->id,
      'activity' => $this->activity,
      'courseRegisteredUser' => new Platform($this->courseRegisteredUser),
      'status_moodle' => $this->status_moodle,
      'qualification_moodle' => $this->qualification_moodle,
      'created_at' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
      'updated_at' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null
    ];
  }
}
