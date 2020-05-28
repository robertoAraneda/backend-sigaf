<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StatusTicket extends Model
{
  protected $fillable = [
    'description'
  ];

  protected $table = 'status_tickets';

  /**
   * Get the Status Ticket formated
   *
   * @return array
   */
  public function format()
  {
    return [
      'links' => [
        'href' => route(
          'api.statusTickets.show',
          ['status_ticket' => $this->id],
          false
        ),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'description' => $this->description,
        'createdAt' => $this->created_at != null
          ? Carbon::parse($this->created_at)->format('d-m-Y')
          : null,
        'updatedAt' => $this->updated_at != null
          ? Carbon::parse($this->updated_at)->format('d-m-Y')
          : null
      ],
      'relationships' => [
        'numberOfElements' => $this->tickets->count(),
        'links' => [
          'href' => route(
            'api.statusTickets.tickets',
            ['status_ticket' => $this->id],
            false
          ),
          'rel' => '/rels/tickets'
        ]
      ]
    ];
  }

  /**
   * Get a list of tickets for the status ticket
   *
   */
  public function tickets()
  {
    return $this->hasMany(Ticket::class);
  }
}
