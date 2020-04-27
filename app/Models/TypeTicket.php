<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TypeTicket extends Model
{
  protected $guarded = [];

  protected $table = 'type_tickets';

  public function format()
  {
    return [
      'links' => [
        'href' => route('api.typeTickets.show', ['type_ticket' => $this->id]),
        'rel' => 'self'
      ],
      'typeTicket' => [
        'id' => $this->id,
        'description' => $this->description,
        'created_at' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
        'updated_at' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null
      ]
    ];
  }

  public function tickets()
  {
    return $this->hasMany(Ticket::class);
  }
}
