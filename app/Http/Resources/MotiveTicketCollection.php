<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MotiveTicketCollection extends ResourceCollection
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
        'href' => route('api.motiveTickets.index', [], false),
        'title' => 'Listado de Motivos de Ticket',
        'rel' => 'self'
      ],
      'quantity' => $this->collection->count(),
      'motiveTickets' => $this->collection->map->format()
    ];
  }
}
