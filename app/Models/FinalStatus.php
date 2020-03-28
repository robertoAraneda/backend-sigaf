<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FinalStatus extends Model
{
  public function format()
  {
    return [
      'id' => $this->id,
      'description' => $this->description,
      'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
      'updated_at' => Carbon::parse($this->updated_at)->diffForHumans()
    ];
  }
}
