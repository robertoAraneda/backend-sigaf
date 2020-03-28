<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusDetailTicket extends Model
{
  protected $guarded = [];

  protected $table = 'status_detail_tickets';

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
