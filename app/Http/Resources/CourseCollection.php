<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseCollection extends ResourceCollection
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
        'href' => route('api.courses.index', [], false),
        'title' => 'Lista de cursos desde Moodle',
        'rel' => 'self'
      ],
      'quantity' => $this->collection->count(),
      'collection' => $this->collection->map->format()
    ];
  }
}
