<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriorityTicket extends Model
{
  protected $guarded = [];

  protected $table = 'priority_tickets';

  protected $dates = ['created_at', 'updated_at'];

  public function format()
  {
    return [
      'id' => $this->id,
      'description' => $this->description,
      'createdAt' => $this->created_at->format('d-m-Y'),
      'updatedAt' => $this->updated_at
    ];
  }
}
