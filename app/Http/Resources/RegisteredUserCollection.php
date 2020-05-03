<?php

namespace App\Http\Resources;

use App\Http\Resources\Json\RegisteredUser;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RegisteredUserCollection extends ResourceCollection
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
        'href' => route('api.registeredUsers.index', [], false),
        'rel' => 'self'
      ],
      'quantity' => $this->collection->count(),
      'collection' => $this->collection->map->format()
    ];
  }
}
