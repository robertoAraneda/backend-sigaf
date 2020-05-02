<?php

namespace App\Http\Resources;

use App\Http\Resources\Json\Category;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
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
        'href' => route('api.categories.index', [], false),
        'title' => 'Lista de categorias desde Moodle',
        'rel' => 'self'
      ],
      'quantity' => $this->collection->count(),
      'categories' => $this->collection->map(function ($category) {
        return new Category($category);
      })
    ];
  }
}
