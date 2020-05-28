<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
  protected $fillable = [
    'description'
  ];

  protected $table = 'classrooms';

  /**
   * Get the Classroom formated
   *
   * @return array
   */
  public function format()
  {
    return [
      'links' => [
        'href' => route(
          'api.classrooms.show',
          ['classroom' => $this->id],
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
            'api.classrooms.courseRegisteredUsers',
            ['classroom' => $this->id],
            false
          ),
          'rel' => '/rels/courseRegisteredUsers'
        ]
      ]
    ];
  }

  /**
   * Get a list of course registered users for the classroom
   *
   */
  public function courseRegisteredUsers()
  {
    return $this->hasMany(CourseRegisteredUser::class);
  }
}
