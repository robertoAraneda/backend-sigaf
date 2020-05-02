<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StatusTicket extends Model
{
  protected $guarded = [];

  protected $table = 'status_tickets';

  public function format()
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
      ],
      'nestedObject' => null,
      'collections' => [
        'tickets' => [
          'links' => [
            'href' => route('api.statusTickets.tickets', ['status_ticket' => $this->id], false),
            'rel' => '/rels/tickets'
          ]
        ]
      ]

    ];
  }

  public function tickets()
  {
    return $this->hasMany(Ticket::class);
  }
}
