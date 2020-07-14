<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  protected $fillable = [
    'description'
  ];

  protected $table = 'roles';

  /**
   * Get the Role formated
   *
   * @return array
   */
  public function format()
  {
    return [
      'links' => [
        'href' => route(
          'api.roles.show',
          ['role' => $this->id],
          false,
        ),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'description' => $this->description,
        'createdAt' => $this->created_at != null
          ?  Carbon::parse($this->created_at)->format('d-m-Y')
          : null,
        'updatedAt' => $this->updated_at != null
          ? Carbon::parse($this->updated_at)->format('d-m-Y')
          : null
      ],
      'relationships' => [
        'numberOfElements' => $this->users->count(),
        'links' => [
          'href' => route(
            'api.roles.users',
            ['role' => $this->id],
            false
          ),
          'rel' => '/rels/users'
        ]
      ]
    ];
  }

  /**
   * Get a list of users for the role
   *
   */
  public function users()
  {
    return $this->hasMany(User::class);
  }
}
