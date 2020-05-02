<?php

namespace App\Http\Resources;

use App\Http\Resources\Json\StatusTicket;
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
        'url' => route('api.statusTickets.index'),
        'href' => route('api.statusTickets.index', [], false),
        'rel' => 'self'
      ],
      'count' => $this->collection->count(),
      'statusTickets' => $this->collection->map->format()
    ];
  }
}
