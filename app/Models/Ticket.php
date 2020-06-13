<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ticket extends Model
{
  protected $table = 'tickets';

  protected $guarded = [];


  public function format()
  {
    return [
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
      'sourceTicket' => [
        'id' => $this->sourceTicket->id,
        'description' => $this->sourceTicket->description
      ],
      'userCreated' => $this->userCreated,
      'userAssigned' => $this->userAssigned,
      'closingDate' => $this->closing_date,
      'createdAt' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('d-m-Y') : null,
      'updatedAt' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('d-m-Y') : null,
    ];
  }

  public function courseRegisteredUser()
  {
    return $this->belongsTo(CourseRegisteredUser::class);
  }

  public function typeTicket()
  {
    return $this->belongsTo(TypeTicket::class);
  }

  public function statusTicket()
  {
    return $this->belongsTo(StatusTicket::class);
  }


  public function priorityTicket()
  {
    return $this->belongsTo(PriorityTicket::class);
  }

  public function motiveTicket()
  {
    return $this->belongsTo(MotiveTicket::class);
  }

  public function sourceTicket()
  {
    return $this->belongsTo(SourceTicket::class);
  }

  public function userCreated()
  {
    return $this->belongsTo(User::class, 'user_create_id');
  }

  public function userAssigned()
  {
    return $this->belongsTo(User::class);
  }

  public function ticketsDetails()
  {
    return $this->hasMany(TicketDetail::class);
  }

  public function alerts()
  {
    return $this->hasMany(Alert::class);
  }
}
