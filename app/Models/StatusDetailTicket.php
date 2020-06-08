<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StatusDetailTicket extends Model
{
  protected $guarded = [];

  protected $table = 'status_detail_tickets';

  public function format()
  {
    return [
      'links' => [
        'href' => route(
          'api.statusDetailTickets.show',
          ['status_detail_ticket' => $this->id],
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
      ]
    ];
  }

  public function ticketDetails()
  {
    return $this->hasMany(TicketDetail::class);
  }
}
