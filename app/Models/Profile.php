<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
  protected $guarded = [];

  protected $table = 'profiles';

  public function format()
  {
    return [
      'id' => $this->id,
      'description' => $this->description,
      'createdAt' => $this->created_at,
      'updatedAt' => $this->updated_at
    ];
  }

    public function courseRegisteredUsers(){
        return $this->hasMany(CourseRegisteredUser::class);
    }
}
