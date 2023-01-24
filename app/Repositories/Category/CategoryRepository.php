<?php
namespace App\Repositories\Category;

interface CategoryRepository {
  public function findAll();
  public function findById($id);
  public function store($data);
  public function update($data, $id);
  public function delete($id);
}