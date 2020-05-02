<?php

namespace App\Http\Resources\Json;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusTicket extends JsonResource
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
        'href' => route('api.statusTickets.show', ['status_ticket' => $this->id], false),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'description' => $this->description,
        'created_at' => $this->created_at != null ? Carbon::parse($this->created_at)->format('d-m-Y') : null,
        'updated_at' => $this->updated_at != null ? Carbon::parse($this->updated_at)->format('d-m-Y') : null
      ]
  }
}
