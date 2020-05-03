<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StatusTicketCollection extends ResourceCollection
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
        'href' => route('api.statusTickets.index', [], false),
        'title' => 'Listado de Estados de Ticket',
        'rel' => 'self'
      ],
      'quantity' => $this->collection->count(),
      'statusTickets' => $this->collection->map->format()
    ];
  }
}
