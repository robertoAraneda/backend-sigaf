<?php

namespace App\Http\Resources\Json;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Platform extends JsonResource
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
        'href' => route('api.platforms.show', ['platform' => $this->id], false),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'description'  => $this->description,
        'status'  => $this->status,
        'createdAt' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('d-m-Y') : null,
        'updatedAt' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('d-m-Y') : null
      ]
    ];
  }
}
