<?php
namespace App\Repositories\Category;

use App\Models\Category;

class CategoryRepositoryImpl implements CategoryRepository {
  protected $model;
  public function __construct(Category $model)
  {
    $this->model = $model;
  }

  public function findAll()
  {
    return $this->model->select('id','name')->get();
  }

  public function findById($id)
  {
    return $this->model->findOrFail($id);
  }

  public function store($data)
  {
    return $this->model->create($data);
  }

  public function update($data, $id)
  {
    return $this->model->where('id', $id)->update($data);
  }

  public function delete($id)
  {
    return $this->model->find($id)->delete();
  }
}