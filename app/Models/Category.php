<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Json\Platform as JsonPlatform;

class Category extends Model
{
  protected $table = 'categories';

  protected $fillable = [
    'description',
    'platform_id',
    'id_category_moodle',
    'status'
  ];

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
        'idPlatformMoodle' => $this->platform_id,
        'idCategoryMoodle' => $this->id_category_moodle,
        'status' => $this->status,
        'platform' => new JsonPlatform($this->platform),
        'createdAt' => $this->created_at != null
          ?  Carbon::parse($this->created_at)->format('d-m-Y')
          : null,
        'updatedAt' => $this->updated_at != null
          ?  Carbon::parse($this->updated_at)->format('d-m-Y')
          : null
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
   * Get a list of courses for the category
   *
   */
  public function courses()
  {
    return $this->hasMany(Course::class);
  }
}
