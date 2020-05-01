<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TypeTicketCollection extends ResourceCollection
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
        'url' => route('api.typeTickets.index'),
        'href' => route('api.typeTickets.index', [], false),
        'rel' => 'self'
      ],
      'count' => $this->collection->count(),
      'typeTickets' => $this->collection->map->format()
    ];
  }
}
