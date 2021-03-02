<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
    'course_registered_user_id',
    'type_ticket_id',
    'status_ticket_id',
    'source_ticket_id',
    'priority_ticket_id',
    'motive_ticket_id',
    'user_create_id',
    'user_assigned_id',
    'closing_date',
  ];


    public function format()
    {
        return [
      'links' => [
        'href' => route(
            'api.tickets.show',
            ['ticket' => $this->id],
            false
        ),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'courseRegisteredUser' => $this->courseRegisteredUser->load(
            'course',
            'course.category',
            'registeredUser',
            'profile:id,description',
            'classroom:id,description',
            'finalStatus:id,description',
            'activityCourseUsers.activity.section'
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
        'version' => $this->version,
        'closingDate' => $this->closing_date != null ?  Carbon::parse($this->closing_date)->format('d-m-Y') : null,
        'timeClosingDate' => $this->closing_date != null ?  Carbon::parse($this->closing_date)->format('H:i') : null,
        'createdAt' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('d-m-Y') : null,
        'timeCreatedAt' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('H:i') : null,
        'updatedAt' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('d-m-Y') : null,
        'ageTicket' => $this->ageTicket($this->created_at, $this->closing_date)
      ],
      'relationships' => [
        'numberOfElements' => $this->ticketsDetails->count(),
        'links' => [
          'href' => route(
              'api.tickets.ticketsDetails',
              ['ticket' => $this->id],
              false
          ),
          'rel' => '/rels/ticketsDetails'
        ]
      ]

    ];
    }

    private function ageTicket($createdDate, $closedDate)
    {
        if (isset($closedDate)) {
            return $createdDate->diffInDays($closedDate);
        } else {
            return $createdDate->diffInDays(Carbon::now());
        }
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
