<?php

namespace App\Services;

use App\Http\Resources\TodoCollection;
use App\Http\Resources\TodoResource;
use App\Repositories\TodoRepository;

class TodoService
{
  private TodoRepository $repository;

  public function __construct(TodoRepository $repository)
  {
    $this->repository = $repository;
  }

  public function getTodos()
  {
    return new TodoCollection($this->repository->getTodos());
  }

  public function createTodo(array $data)
  {
    $todo = $this->repository->createTodo($data);
    return new TodoResource($todo);
  }

  public function updateTodo(array $data, string $id)
  {
    $todo = $this->repository->updateTodo($data, $id);
    return new TodoResource($todo);
  }

  public function deleteTodo(string $id)
  {
    $this->repository->deleteTodo($id);
  }
}
