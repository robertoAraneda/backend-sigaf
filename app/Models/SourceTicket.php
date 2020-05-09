<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SourceTicket extends Model
{
  protected $guarded = [];

  protected $table = 'source_tickets';

  /**
   * Get the Source Ticket formated
   *
   * @return array
   */
  public function format()
  {
    return [
      'links' => [
        'href' => route(
          'api.sourceTickets.show',
          ['source_ticket' => $this->id],
          false
        ),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'description' => $this->description,
        'createdAt' => $this->created_at != null
          ?  Carbon::parse($this->created_at)->format('d-m-Y')
          : null,
        'updatedAt' => $this->updated_at != null
          ?  Carbon::parse($this->updated_at)->format('d-m-Y')
          : null
      ],
      'nestedObjects' => [],
      'relationships' => [
        'numberOfElements' => $this->tickets->count(),
        'links' => [
          'href' => route(
            'api.sourceTickets.tickets',
            ['source_ticket' => $this->id],
            false
          ),
          'rel' => '/rels/tickets'
        ]
      ]
    ];
  }

  /**
   * Get a list of tickets for the source ticket
   *
   */
  public function tickets()
  {
    return $this->hasMany(Ticket::class);
  }
}
