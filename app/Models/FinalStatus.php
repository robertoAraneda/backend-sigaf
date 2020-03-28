<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalStatus extends Model
{
  protected $guarded = [];

  protected $table = 'final_statuses';

  public function format()
  {
    return [
      'id' => $this->id,
      'description' => $this->description,
      'createdAd' => $this->created_at,
      'updatedAd' => $this->updated_at
    ];
  }
}
