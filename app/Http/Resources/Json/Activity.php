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
        'href' => route('api.activities.show', ['activity' => $this->id], false),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'description'  => $this->description,
        'type'  => $this->type,
        'weighing'  => $this->weighing,
        'idActivityMoodle'  => $this->id_activity_moodle,
        'section' => $this->section,
        'createdAt' => $this->created_at != null
          ?  Carbon::parse($this->created_at)->format('d-m-Y')
          : null,
        'updatedAt' => $this->updated_at != null
          ?  Carbon::parse($this->updated_at)->format('d-m-Y')
          : null
      ]
    ];
    }
}
