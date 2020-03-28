<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriorityTicket extends Model
{
  protected $guarded = [];

  protected $table = 'priority_tickets';

  public function format()
  {
    return [
      'id' => $this->id,
      'description' => $this->description,
      'createdAt' => $this->created_at,
      'updatedAt' => $this->updated_at
    ];
  }
}
