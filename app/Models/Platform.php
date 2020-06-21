<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
  protected $fillable = [
    'description'
  ];

  protected $table = 'platforms';

  /**
   * Get the resource formated
   *
   * @return array
   */
  public function format()
  {
    return [
      'links' => [
        'href' => route(
          'api.platforms.show',
          ['platform' => $this->id],
          false
        ),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'description'  => $this->description,
        'status'  => $this->status,
        'createdAt' => $this->created_at != null
          ?  Carbon::parse($this->created_at)->format('d-m-Y')
          : null,
        'updatedAt' => $this->updated_at != null
          ?  Carbon::parse($this->updated_at)->format('d-m-Y')
          : null
      ],
      'relationships' => [
        'numberOfElements' => $this->categories->count(),
        'links' => [
          'href' => route(
            'api.platforms.categories', //nombre de la ruta (names en cada Route en archivo api.php)
            ['platform' => $this->id], //parametros necesarios para construir la URL
            false //obtener ruta relativa
          ),
          'rel' => '/rels/categories' //relación con la clase principal
        ]
      ]

    ];
  }

  /**
   * Get the categories for the platform
   *
   */
  public function categories()
  {
    return $this->hasMany(Category::class);
  }
}
