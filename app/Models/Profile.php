<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
  protected $guarded = [];

  protected $table = 'profiles';

  /**
   * Get the Profile formated
   *
   * @return array
   */
  public function format()
  {
    return [
      'links' => [
        'href' => route(
          'api.profiles.show',
          ['profile' => $this->id],
          false
        ),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'description' => $this->description,
        'createdAt' => $this->created_at != null
          ?  Carbon::parse($this->created_at)->format('d-m-Y')
          : null,
        'updatedAt' => $this->updated_at != null
          ?  Carbon::parse($this->updated_at)->format('d-m-Y')
          : null
      ],
      'relationships' => [
        'numberOfElements' => $this->courseRegisteredUsers->count(),
        'links' => [
          'href' => route(
            'api.profiles.courseRegisteredUsers',
            ['profile' => $this->id],
            false
          ),
          'rel' => '/rels/tickets'
        ]
      ]
    ];
  }

  /**
   * Get a list of course regostered users for the profile
   *
   */
  public function courseRegisteredUsers()
  {
    return $this->hasMany(CourseRegisteredUser::class);
  }
}
