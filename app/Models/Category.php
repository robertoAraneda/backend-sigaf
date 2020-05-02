<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Json\Platform as JsonPlatform;

class Category extends Model
{
  protected $table = 'categories';

  protected $guarded = [];

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
        'createdAt' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('d-m-Y') : null,
        'updatedAt' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('d-m-Y') : null
      ],
      'nestedObject' => [
        'platform' => new JsonPlatform($this->platform)
      ],
      'collections' => [
        'courses' => [
          'links' => [
            'href' => route('api.categories.courses', ['id' => $this->id], false),
            'rel' => '/rels/courses'
          ]
        ]
      ]
    ];
  }

  public function platform()
  {
    return $this->belongsTo(Platform::class);
  }

  public function courses()
  {
    return $this->hasMany(Course::class);
  }
}
