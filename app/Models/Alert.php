<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
  protected $guarded = [];

  protected $table = 'alerts';

  public function format()
  {

    return [
      'id' => $this->id,
      'ticket' => $this->ticket->load(
        'courseRegisteredUser',
        'courseRegisteredUser.course',
        'courseRegisteredUser.registeredUser',
        'courseRegisteredUser.profile:id,description',
        'courseRegisteredUser.classroom:id,description',
        'courseRegisteredUser.finalStatus:id,description',
        'inOutTicket:id,description',
        'statusTicket:id,description',
        'priorityTicket:id,description',
        'motiveTicket:id,description'
      ),
      'user' => $this->user,
      'time' => $this->time,
      'date' => $this->date,
      'statusReminder' => $this->status_reminder,
      'statusNotification' => $this->status_notification,
      'comment' => $this->comment,
      'createdAt' => $this->created_at,
      'updatedAt' => $this->updated_at

    ];
  }

  public function ticket()
  {
    return $this->belongsTo(Ticket::class);
  }
}
