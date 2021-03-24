<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CourseTutor extends Model
{
  protected $table = 'course_tutors';

  public function course()
  {
    return $this->belongsTo(Course::class);
  }

  public function tutor()
  {
    return $this->belongsTo(User::class);
  }

  public function format()
  {
    return [
      'links' => [
        'href' => route('api.courseTutors.show', ['course_tutor' => $this->id], false),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'course' => $this->course,
        'tutor' => $this->tutor,
        'createdAt' => $this->created_at != null ? Carbon::parse($this->created_at)->format('d-m-Y') : null,
        'updatedAt' => $this->updated_at != null ? Carbon::parse($this->updated_at)->format('d-m-Y') : null
      ],
    ];
  }
}
