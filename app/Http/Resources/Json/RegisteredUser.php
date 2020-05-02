<?php

namespace App\Http\Resources\Json;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisteredUser extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
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
      ]
    ];
  }
}
