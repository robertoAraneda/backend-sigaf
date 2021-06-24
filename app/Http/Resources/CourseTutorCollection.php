<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseTutorCollection extends ResourceCollection
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
        'href' => [
          'course' => route(
            'api.courseTutors.course',
            [],
            false
          ),
          'tutor' => route(
            'api.courseTutors.tutor',
            [],
            false
          )
        ],
        'title' => 'Listado de relaciones entre cursos y tutores',
        'rel' => 'self'
      ],
      'numberOfElements' => $this->collection->count(),
      'collections' => $this->collection->map->format()
    ];
  }
}
