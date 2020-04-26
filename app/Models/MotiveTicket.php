<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotiveTicket extends Model
{
  protected $guarded = [];

  protected $table = 'motive_tickets';

  public function format()
  {
    return [
      'id' => $this->id,
      'description' => $this->description,
      'createdAt' => $this->created_at,
      'updatedAt' => $this->updated_at,
    ];
  }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
}
