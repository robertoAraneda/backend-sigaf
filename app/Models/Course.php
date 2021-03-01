<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Json\Category as JsonCategory;

class Course extends Model
{
  protected $fillable = [
    'description',
    'category_id',
    'email',
    'password',
    'id_course_moodle',
    'status'
  ];

  protected $table = 'courses';

  /**
   * Get the Course formated
   *
   * @return array
   */
  public function format()
  {
    return [
      'links' => [
        'href' => route('api.courses.show', ['course' => $this->id], false),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'description'  => $this->description,
        'email' => $this->email,
        'password' => $this->password,
        'idCourseMoodle'  => $this->id_course_moodle,
        'status'  => $this->status,
        'createdAt' => $this->created_at != null
          ?  Carbon::parse($this->created_at)->format('d-m-Y')
          : null,
        'updatedAt' => $this->updated_at != null
          ?  Carbon::parse($this->updated_at)->format('d-m-Y')
          : null,
        'category' => new JsonCategory($this->category)
      ],
      'relationships' => [
        'activities' => [
          'numberOfElements' => $this->activities()->count(),
          'links' => [
            'href' => route('api.courses.activities', ['course' => $this->id], false),
            'rel' => '/rels/activities'
          ],
        ],
        'registeredUsers' => [
          'numberOfElements' => $this->registeredUsers()->count(),
          'links' => [
            'href' => route('api.courses.registeredUsers', ['course' => $this->id], false),
            'rel' => '/rels/registeredUsers'
          ]
        ]
      ]
    ];
  }

  /**
   * Get the category for the course
   *
   */
  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  /**
   * Get a list of activities for the course
   *
   */
  public function activities()
  {
    return $this->hasMany(Activity::class);
  }

  /**
   * Get a list of users for the course
   *
   */
  public function registeredUsers()
  {
    return $this->hasMany(CourseRegisteredUser::class);
  }
}
