<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
  protected $guarded = [];

  protected $table = 'ticket_details';

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
      'userCreated' => $this->userCreated,
      'statusDetailTicket' => $this->statusDetailTicket != null ?  [
        'id' => $this->statusDetailTicket->id,
        'description' =>  $this->statusDetailTicket->id
      ] : null,
      'comment' => $this->comment

    ];
  }

  public function userCreated()
  {
    return $this->belongsTo(User::class);
  }

  public function statusDetailTicket()
  {
    return $this->belongsTo(StatusDetailTicket::class);
  }

  public function ticket()
  {
    return $this->belongsTo(Ticket::class);
  }
}
