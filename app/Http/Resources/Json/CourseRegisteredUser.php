<?php

namespace App\Http\Resources\Json;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseRegisteredUser extends JsonResource
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
        'href' => route('api.courseRegisteredUsers.show', ['course_registered_user' => $this->id], false),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'lastAccessRegisteredMoodle'  => $this->last_access_registered_moodle,
        'finalQualificationMoodle' => $this->final_qualification_moodle,
        'finalQualification' => $this->final_qualification,
        'registeredUser' => $this->registeredUser,
        'status'  => $this->status,
        'classroom' => $this->classroom,
        'profile' => $this->profile,
        'course' => $this->course,
        'finalStatus' => $this->finalStatus,
        'isSincronized' => $this->is_sincronized,
        'created_at' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('d-m-Y') : null,
        'updated_at' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('d-m-Y') : null
      ]
    ];
  }
}
