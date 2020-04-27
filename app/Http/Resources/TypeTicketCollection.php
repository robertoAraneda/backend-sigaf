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
        'href' => route('api.typeTickets.index'),
        'rel' => 'self'
      ],
      'typeTickets' => $this->collection->map->format()
    ];
  }
}
