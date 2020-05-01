<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeTicket extends Model
{
  protected $guarded = [];

  protected $table = 'type_tickets';

  public function tickets()
  {
    return $this->hasMany(Ticket::class);
  }
}
