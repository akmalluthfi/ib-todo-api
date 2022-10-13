<?php

namespace App\Repositories;

use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class TodoRepository
{
  private function getUserId()
  {
    return Auth::id();
  }

  public function getTodos()
  {
    $user_id = $this->getUserId();
    $todos = Todo::where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(10);
    return $todos;
  }

  public function createTodo(array $data): Todo
  {
    $todo = new Todo;
    $todo->title = $data['title'];
    $todo->description = $data['description'];
    $todo->due_date = $data['due_date'];
    $todo->is_complete = $data['is_complete'];
    $todo->user_id = $this->getUserId();
    $todo->save();

    return $todo;
  }

  public function updateTodo(array $data, string $id): Todo
  {
    $todo = Todo::find($id);
    $todo->title = $data['title'];
    $todo->description = $data['description'];
    $todo->due_date = $data['due_date'];
    $todo->is_complete = $data['is_complete'];
    $todo->save();

    return $todo;
  }

  public function deleteTodo(string $id)
  {
    Todo::destroy($id);
  }
}
