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
        'createdAt' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
        'updatedAt' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null
      ],
      'nestedObject' => [
        'platform' => new JsonPlatform($this->platform)
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
