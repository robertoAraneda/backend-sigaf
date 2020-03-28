<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
  protected $guarded = [];

  protected $table = 'ticket_details';

  public function format()
  {
    return [
      'id' => $this->id,
      'userCreatedId' => $this->user_created_id,
      'statusDetailTicketId' => $this->status_detail_ticket_id,
      'comment' => $this->comment

    ];
  }
}
