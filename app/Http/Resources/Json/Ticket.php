<?php

namespace App\Http\Resources\Json;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Ticket extends JsonResource
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
        'url' => route('api.tickets.show', ['ticket' => $this->id]),
        'href' => route('api.tickets.show', ['ticket' => $this->id], false),
        'rel' => 'self'
      ],
      'ticket' => [
        'id' => $this->id,
        'courseRegisteredUser' => $this->courseRegisteredUser->load(
          'course',
          'registeredUser',
          'profile:id,description',
          'classroom:id,description',
          'finalStatus:id,description'
        ),
        'typeTicket' => [
          'id' => $this->typeTicket->id,
          'description' => $this->typeTicket->description
        ],
        'statusTicket' => [
          'id' => $this->statusTicket->id,
          'description' => $this->statusTicket->description
        ],
        'priorityTicket' => [
          'id' => $this->priorityTicket->id,
          'description' => $this->priorityTicket->description
        ],
        'motiveTicket' => [
          'id' => $this->motiveTicket->id,
          'description' => $this->motiveTicket->description
        ],
        'userCreated' => $this->userCreated,
        'userAssigned' => $this->userAssigned,
        'closingDate' => $this->closing_date,
        'observation' => $this->observation,
        'createdAt' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
        'updatedAt' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null
      ]
    ];
  }
}