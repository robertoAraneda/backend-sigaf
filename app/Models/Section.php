<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
  protected $fillable = [
    'description',
  ];

  protected $table = 'sections';

  public function format()
  {
    return [
      'links' => [
        'href' => route(
          'api.sections.show',
          ['section' => $this->id],
          false
        ),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'description' => $this->description,
        'activities' => $this->activities,
        'createdAt' => $this->created_at != null
          ?  Carbon::parse($this->created_at)->format('d-m-Y')
          : null,
        'updatedAt' => $this->updated_at != null
          ?  Carbon::parse($this->updated_at)->format('d-m-Y')
          : null
      ],
    ];
  }
  public function activities()
  {
    return $this->hasMany(Activity::class);
  }
}
