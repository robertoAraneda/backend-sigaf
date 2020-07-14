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
        'href' => route(
          'api.typeTickets.index',
          [],
          false
        ),
        'title' => 'Listado de Tipos de Ticket',
        'rel' => 'self'
      ],
      'numberOfElements' => $this->collection->count(),
      'collections' => $this->collection->map->format()
    ];
  }
}
