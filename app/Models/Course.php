<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Json\Category as JsonCategory;

class Course extends Model
{
  protected $guarded = [];

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
        'idCategoryMoodle'  => $this->id_category_moodle,
        'status'  => $this->status,
        'createdAt' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('d-m-Y') : null,
        'updatedAt' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('d-m-Y') : null
      ],
      'nestedObject' => [
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


  public function links()
  {
    return [
      'class' => 'course',
      'properties' => [
        'id' => $this->id,
        'description'  => $this->description,
        'id_category_moodle'  => $this->id_category_moodle,
        'status'  => $this->status,
        'created_at' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
        'updated_at' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null
      ],
      'entities' => [
        [
          'class' => 'category',
          'rel' => '/rels/category',
          'properties' => [
            'id' => $this->category->id,
            'description' => $this->category->description
          ],
          'links' => [
            'href' => route('api.categories.show', ['category' => $this->id], false),
            'title' => 'Categoria asociada',
            'rel' => 'self'
          ]
        ],
      ],
      'links' => [
        'rel' => 'self',
        'title' => 'Detalle curso',
        'href' => route('api.courses.show', ['course' => $this->id], false),
      ],

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
