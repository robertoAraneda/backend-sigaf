<?php

namespace App\Http\Resources\Json;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Alert extends JsonResource
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
        'url' => route('api.alerts.show', ['alert' => $this->id]),
        'href' => route('api.alerts.show', ['alert' => $this->id], false),
        'rel' => 'self'
      ],
      'alert' => [
        'id' => $this->id,
        'time' => $this->time,
        'date' => $this->date,
        'statusReminder' => $this->status_reminder,
        'statusNotification' => $this->status_notification,
        'comment' => $this->comment,
        'created_at' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
        'updated_at' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null,
        'ticket' => $this->ticket->load(
          'courseRegisteredUser',
          'courseRegisteredUser.course',
          'courseRegisteredUser.registeredUser',
          'courseRegisteredUser.profile:id,description',
          'courseRegisteredUser.classroom:id,description',
          'courseRegisteredUser.finalStatus:id,description',
          'typeTicket:id,description',
          'statusTicket:id,description',
          'priorityTicket:id,description',
          'motiveTicket:id,description'
        ),
        'user' => $this->user,
      ]
    ];
  }
}
