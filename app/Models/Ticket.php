<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

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
      'userCreated' => $this->userCreated,
      'userAssigned' => $this->userAssigned,
      'closingDate' => $this->closing_date,
      'observation' => $this->observation,
      'createdAt' => $this->created_at,
      'updatedAt' => $this->updated_at
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

  public function userCreated()
  {
    return $this->belongsTo(User::class);
  }

  public function userAssigned()
  {
    return $this->belongsTo(User::class);
  }
}
