<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
  protected $guarded = [];

  protected $table = 'platforms';

  public function format()
  {
    return [
      'links' => [
        'href' => route('api.platforms.show', ['platform' => $this->id], false),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'description'  => $this->description,
        'status'  => $this->status,
        'created_at' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
        'updated_at' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null
      ],
      'nestedObject' => null,
      'collections' => [
        'categories' => [
          'links' => [
            'href' => route('api.platforms.categories', ['id' => $this->id], false),
            'rel' => '/rels/categories'
          ]
        ]
      ]
    ];
  }

  public function categories()
  {
    return $this->hasMany(Category::class);
  }
}
