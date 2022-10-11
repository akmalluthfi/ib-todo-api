<?php

namespace App\Services;

use App\Models\Todo;
use App\Repositories\TodoRepository;

class TodoService
{
  private $repository;

  public function __construct()
  {
    $this->repository = new TodoRepository();
  }

  public function getTodos(string $user_id)
  {
    return $this->repository->getTodosByUserId($user_id);
  }
}
