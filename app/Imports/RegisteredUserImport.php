<?php

namespace App\Imports;

use App\Models\RegisteredUser;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class RegisteredUserImport implements ToModel
{

  use Importable;

  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */

  public function model(array $row)
  {
    return new RegisteredUser([
      'rut'     => $row[0],
      'name'    => $row[1],
      'last_name'     => $row[2],
      'mother_last_name'    => $row[3],
      'email'    => $row[4],
      'phone'      => $row[5],
      'mobile'      => $row[6],
      'address'      => $row[7],
      'city'      => $row[8],
      'region'      => $row[9],
      'rbd_school'    => $row[10],
      'name_school'      => $row[11],
      'city_school'      => $row[12],
      'region_school'      => $row[13],
      'phone_school'  => $row[14]
    ]);
  }
}
