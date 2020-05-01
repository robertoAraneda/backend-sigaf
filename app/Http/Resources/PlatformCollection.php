<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PlatformCollection extends ResourceCollection
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
        'url' => route('api.platforms.index'),
        'href' => route('api.platforms.index', [], false),
        'rel' => 'self'
      ],
      'count' => $this->collection->count(),
      'platforms' => $this->collection->map->format()
    ];
  }
}
