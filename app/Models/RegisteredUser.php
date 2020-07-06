<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class RegisteredUser extends Model
{

  protected $table = 'registered_users';

  protected $fillable = [
    'rut',
    'name',
    'last_name',
    'mother_last_name',
    'email',
    'phone',
    'mobile',
    'address',
    'region',
    'rbd_school',
    'name_school',
    'city_school',
    'region_school',
    'phone_school'
  ];


  public function format()
  {
    return [
      'links' => [
        'href' => route('api.registeredUsers.show', ['registered_user' => $this->id], false),
        'rel' => 'self'
      ],
      'properties' => [
        'id' => $this->id,
        'rut' => $this->rut,
        'name' => $this->name,
        'last_name' => $this->last_name,
        'mother_last_name' => $this->mother_last_name,
        'email' => $this->email,
        'phone' => $this->phone,
        'mobile' => $this->mobile,
        'address' => $this->address,
        'city' => $this->city,
        'region' => $this->region,
        'rbd_school' => $this->rbd_school,
        'name_school' => $this->name_school,
        'city_school' => $this->city_school,
        'region_school' => $this->region_school,
        'phone_school' => $this->phone_school,
        'idRegisteredMoodle' => $this->id_registered_moodle,
        'rutRegisteredMoodle' => $this->rut_registered_moodle,
        'nameRegisteredMoodle' => $this->name_registered_moodle,
        'emailRegisteredMoodle' => $this->email_registered_moodle,
        'statusMoodle' => $this->status_moodle,
        'createdAat' => $this->created_at != null ?  Carbon::parse($this->created_at)->format('d-m-Y') : null,
        'updatedAat' => $this->updated_at != null ?  Carbon::parse($this->updated_at)->format('d-m-Y') : null
      ],
      'collections' => [
        'courses' => [
          'links' => [
            'href' => route('api.registeredUsers.courses', ['registered_user' => $this->id], false),
            'rel' => '/rels/activityCourseUser'
          ],
          'data' => $this->courseRegisteredUsers->load('course')
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
