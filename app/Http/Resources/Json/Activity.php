<?php

namespace App\Http\Resources\Json;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Activity extends JsonResource
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
        'url' => route('api.activities.show', ['activity' => $this->id]),
        'href' => route('api.activities.show', ['activity' => $this->id], false),
        'rel' => 'self'
      ],
      'id' => $this->id,
      'description'  => $this->description,
      'type'  => $this->type,
      'weighing'  => $this->weighing,
      'id_activity_moodle'  => $this->id_activity_moodle,
      'course'  => new Course($this->course),
      'created_at' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
      'updated_at' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null

    ];
  }
}
