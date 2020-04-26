<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InOutTicket extends Model
{
  protected $guarded = [];

  protected $table = 'in_out_tickets';

  public function format()
  {
    return [
      'id' => $this->id,
      'description' => $this->description,
      'createdAt' => $this->created_at,
      'updatedAt' => $this->updated_at
    ];
  }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
}
