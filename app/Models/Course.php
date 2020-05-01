<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
  protected $guarded = [];

  protected $table = 'courses';

  public function format()
  {
    return [
      'links' => [
        'url' => route('api.categories.show', ['category' => $this->id]),
        'href' => route('api.categories.show', ['category' => $this->id], false),
        'rel' => 'self'
      ],
      'activity' => [
        'id' => $this->id,
        'description'  => $this->description,
        'platform'  => $this->platform,
        'id_category_moodle'  => $this->id_category_moodle,
        'status'  => $this->status,
        'created_at' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
        'updated_at' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null
      ]
    ];
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function activities()
  {
    return $this->hasMany(Activity::class);
  }
}
