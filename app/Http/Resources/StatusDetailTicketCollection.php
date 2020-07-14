<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StatusDetailTicketCollection extends ResourceCollection
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
          'api.statusDetailTickets.index',
          [],
          false
        ),
        'title' => 'Listado de intentos de contacto Ticket',
        'rel' => 'self'
      ],
      'numberOfElements' => $this->collection->count(),
      'collections' => $this->collection->map->format()
    ];
  }
}
