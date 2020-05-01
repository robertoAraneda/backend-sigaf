<?php

namespace App\Http\Resources\Json;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TypeTicket extends JsonResource
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
        'url' => route('api.typeTickets.show', ['type_ticket' => $this->id]),
        'href' => route('api.typeTickets.show', ['type_ticket' => $this->id], false),
        'rel' => 'self'
      ],
      'id' => $this->id,
      'description' => $this->description,
      'created_at' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
      'updated_at' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null

    ];
  }
}
