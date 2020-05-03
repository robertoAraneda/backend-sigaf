<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PriorityTicketCollection extends ResourceCollection
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
        'href' => route('api.priorityTickets.index', [], false),
        'title' => 'Listado de Prioridades de Ticket',
        'rel' => 'self'
      ],
      'quantity' => $this->collection->count(),
      'priorityTickets' => $this->collection->map->format()
    ];
  }
}
