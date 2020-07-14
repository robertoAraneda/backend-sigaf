<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
  protected $guarded = [];

  protected $table = 'ticket_details';

  public function format()
  {

    return [
      'links' => [
        'href' => route(
          'api.ticketDetails.show',
          ['ticket_detail' => $this->id],
          false
        ),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
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
        'userCreated' => $this->userCreated,
        'statusDetailTicket' => $this->statusDetailTicket != null ?  [
          'id' => $this->statusDetailTicket->id,
          'description' =>  $this->statusDetailTicket->description
        ] : null,
        'comment' => $this->comment,
        'createdAt' => $this->created_at != null
          ?  Carbon::parse($this->created_at)->format('d-m-Y')
          : null,
        'updatedAt' => $this->updated_at != null
          ?  Carbon::parse($this->updated_at)->format('d-m-Y')
          : null
      ]
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
