<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Json\Platform as JsonPlatform;

class Category extends Model
{
  protected $table = 'categories';

  protected $guarded = [];

  /**
   * Get the Category formated
   *
   * @return array
   */
  public function format()
  {
    return [
      'links' => [
        'href' => route('api.categories.show', ['category' => $this->id], false),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'description' => $this->description,
        'idCategoryMoodle' => $this->id_category_moodle,
        'status' => $this->status,
        'createdAt' => $this->created_at != null
          ?  Carbon::parse($this->created_at)->format('d-m-Y')
          : null,
        'updatedAt' => $this->updated_at != null
          ?  Carbon::parse($this->updated_at)->format('d-m-Y')
          : null
      ],
      'nestedObjects' => [
        'platform' => new JsonPlatform($this->platform)
      ],
      'relationships' => [
        'numberOfElements' => $this->courses()->count(),
        'links' => [
          'href' => route(
            'api.categories.courses',
            ['category' => $this->id],
            false
          ),
          'rel' => '/rels/courses'
        ]
      ]
    ];
  }

  /**
   * Get the platform for the category
   *
   */
  function platform()
  {
    return $this->belongsTo(Platform::class);
  }

  /**
   * Get the courses for the category
   *
   */
  public function courses()
  {
    return $this->hasMany(Course::class);
  }
}
