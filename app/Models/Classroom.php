<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
  protected $guarded = [];

  protected $table = 'classrooms';

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
