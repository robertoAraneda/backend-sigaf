<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ActivityCollection extends ResourceCollection
{
  /**
   * Transform the resource collection into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'links' => [
        'url' => route('api.activities.index'),
        'href' => route('api.activities.index', [], false),
        'rel' => 'self'
      ],

      'activities' => $this->collection->map->format()
    ];
  }
}
