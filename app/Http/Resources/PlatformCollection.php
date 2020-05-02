<?php

namespace App\Http\Resources;

use App\Http\Resources\Json\Platform;
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
        'href' => route('api.platforms.index', [], false),
        'title' => 'Plataformas disponibles desde Moodle',
        'rel' => 'self'
      ],
      'quantity' => $this->collection->count(),
      'collection' => $this->collection->map(function ($platform) {
        return new Platform($platform);
      })
    ];
  }
}
