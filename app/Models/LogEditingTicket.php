<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;

class LogEditingTicket extends Model
{
    protected $table = 'log_editing_tickets';
    
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function format()
    {
        return [
      'links' => [
        'href' => route(
            'api.logEditingTickets.show',
            ['log_editing_ticket' => $this->id],
            false
        ),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'ticket' => $this->ticket,
        'user' => $this->user,
        'createdAt' => $this->created_at != null
          ? Carbon::parse($this->created_at)->format('d-m-Y')
          : null,
        'updatedAt' => $this->updated_at != null
          ? Carbon::parse($this->updated_at)->format('d-m-Y')
          : null
      ],
    ];
    }
}
