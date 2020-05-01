<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
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
        'url' => route('api.categories.index'),
        'href' => route('api.categories.index', [], false),
        'rel' => 'self'
      ],
      'count' => $this->collection->count(),
      'categories' => $this->collection->map->format()
    ];
  }
}
