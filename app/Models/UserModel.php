<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
  protected $table = 'users';
  protected $primaryKey = 'id';
  protected $allowedFields = ['firstname', 'lastname', 'password', 'email'];

  protected $beforeInsert = ['beforeInsert'];
  protected $beforeUpdate = ['beforeUpdate'];

  public function beforeInsert(array $data)
  {
    $data = $this->passwordHash($data);
    return $data;
  }

  public function beforeUpdate(array $data)
  {
    $data = $this->passwordHash($data);
    return $data;
  }

  public function passwordHash(array $data)
  {
    if (isset($data['data']['password'])) {
      $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
    }
    return $data;
  }
}
