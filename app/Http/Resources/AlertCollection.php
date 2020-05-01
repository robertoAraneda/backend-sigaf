<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AlertCollection extends ResourceCollection
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
        'url' => route('api.alerts.index'),
        'href' => route('api.alerts.index', [], false),
        'rel' => 'self'
      ],
      'count' => $this->collection->count(),
      'alerts' => $this->collection->map->format()
    ];
  }
}
