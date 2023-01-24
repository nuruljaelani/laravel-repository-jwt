<?php
namespace App\Repositories\User;
use App\Models\User;

class UserRepositoryImpl implements UserRepository {
  protected $model;
  public function __construct(User $model)
  {
    $this->model = $model;
  }
  public function register($data)
  {
    return $this->model->insert([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => $data['password']
    ]);
  }
}