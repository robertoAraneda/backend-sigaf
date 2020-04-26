<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  protected $guarded = [];

  protected $table = 'roles';

  public function format()
  {
    return [
      'id' => $this->id,
      'description' => $this->description,
      'createdAt' => $this->created_at,
      'updatedAt' => $this->updated_at
    ];
  }

  public function users(){
      return $this->hasMany(User::class);
  }
}
