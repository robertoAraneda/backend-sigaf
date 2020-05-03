<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TypeTicket extends Model
{
  protected $guarded = [];

  protected $table = 'type_tickets';

  public function format()
  {
    return [
      'links' => [
        'href' => route('api.typeTickets.show', ['type_ticket' => $this->id], false),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'description' => $this->description,
        'createdAt' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('d-m-Y') : null,
        'updatedAt' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('d-m-Y') : null
      ],
      'nestedObject' => null,
      'collections' => [
        'tickets' => [
          'links' => [
            'href' => route('api.typeTickets.tickets', ['type_ticket' => $this->id], false),
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
