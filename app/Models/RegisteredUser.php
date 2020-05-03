<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class RegisteredUser extends Model
{

  protected $table = 'registered_users';

  protected $guarded = [];


  public function format()
  {
    $courseRegisteredUser = $this->courseRegisteredUsers->load('course');


    return [
      'links' => [
        'href' => route('api.registeredUsers.show', ['registered_user' => $this->id], false),
        'rel' => 'self'
      ],
      'properties' => [
        'idRegisteredMoodle' => $this->id_registered_moodle,
        'rutRegisteredMoodle' => $this->rut_registered_moodle,
        'nameRegisteredMoodle' => $this->name_registered_moodle,
        'emailRegisteredMoodle' => $this->email_registered_moodle,
        'statusMoodle' => $this->status_moodle,
        'createdAat' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('d-m-Y') : null,
        'updatedAat' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('d-m-Y') : null
      ],
      'nestedObject' => [
        'userCreated' => $this->createdUser,
        'courseRegisteredUser' => $courseRegisteredUser,
      ],
      'collections' => [
        'courses' => [
          'links' => [
            'href' => route('api.registeredUsers.courses', ['registered_user' => $this->id], false),
            'rel' => '/rels/activityCourseUser'
          ]
        ]
      ]
    ];
  }

  public function createdUser()
  {
    return $this->belongsTo(User::class);
  }

  public function updatedUser()
  {
    return $this->belongsTo(User::class);
  }

  public function courseRegisteredUsers()
  {
    return $this->hasMany(CourseRegisteredUser::class);
  }
}
