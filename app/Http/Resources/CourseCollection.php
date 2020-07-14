<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Helpers\Paginate;

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
      'links_' => [
        'href' => route('api.courses.index', [], false),
        'title' => 'Cursos disponibles desde Moodle',
        'rel' => 'self'
      ],
      'numberOfElements' => $this->collection->count(),
      'collections' => $this->collection->map->format()
    ];
  }
}
