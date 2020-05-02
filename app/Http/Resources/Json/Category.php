<?php

namespace App\Http\Resources\Json;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
        'href' => route('api.categories.show', ['category' => $this->id], false),
        'rel' => 'self'
      ],
      'id' => $this->id,
      'description' => $this->description,
      'id_category_moodle' => $this->id_category_moodle,
      'status' => $this->status,
      'created_at' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
      'updated_at' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null
    ];
  }
}
