<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TicketDetailCollection extends ResourceCollection
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
          'api.ticketDetails.index',
          [],
          false
        ),
        'title' => 'Listado de Detalle de Ticket',
        'rel' => 'self'
      ],
      'numberOfElements' => $this->collection->count(),
      'collections' => $this->collection->map->format()
    ];
  }
}
