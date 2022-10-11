<?php

namespace App\Repositories;

use App\Models\Todo;

class TodoRepository
{
  public function getTodosByUserId(string $user_id)
  {
    $todos = Todo::where('user_id', $user_id)->get();
    return $todos;
  }
}
