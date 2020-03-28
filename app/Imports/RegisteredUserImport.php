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
    ]);
  }
}
