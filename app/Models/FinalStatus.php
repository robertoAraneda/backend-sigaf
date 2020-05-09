<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FinalStatus extends Model
{
  protected $guarded = [];

  protected $table = 'final_statuses';

  /**
   * Get the Final Status formated
   *
   * @return array
   */
  public function format()
  {
    return [
      'links' => [
        'href' => route(
          'api.finalStatuses.show',
          ['final_status' => $this->id],
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
      'nestedObjects' => [],
      'relationships' => [
        'numberOfElements' => $this->courseRegisteredUsers->count(),
        'links' => [
          'href' => route(
            'api.finalStatuses.courseRegisteredUsers',
            ['final_status' => $this->id],
            false
          ),
          'rel' => '/rels/courseRegisteredUsers'
        ]
      ]
    ];
  }

  /**
   * Get a list of course regostered users for the final status
   *
   */
  public function courseRegisteredUsers()
  {
    return $this->hasMany(CourseRegisteredUser::class);
  }
}
