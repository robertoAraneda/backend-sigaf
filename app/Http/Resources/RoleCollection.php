<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
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
          'api.roles.index',
          [],
          false
        ),
        'title' => 'Listado de Roles de Usuario',
        'rel' => 'self'
      ],
      'numberOfElements' => $this->collection->count(),
      'collecions' => $this->collection->map->format()
    ];
  }
}
