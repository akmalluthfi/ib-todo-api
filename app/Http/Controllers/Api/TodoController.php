<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use App\Services\TodoService;

class TodoController extends Controller
{
    private TodoService $service;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(TodoService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->getTodos();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TodoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        $validatedData  = $request->validated();
        $todo = $this->service->createTodo($validatedData);
        return response()->json([
            'message' => 'Todo Created Successfully',
            'data' => $todo,
            'error' => null
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TodoRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TodoRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $todo = $this->service->updateTodo($validatedData, $id);
        return response()->json([
            'message' => 'Todo Updated Successfully',
            'data' => $todo,
            'error' => null
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $this->service->deleteTodo($id);
        return response()->json([
            'message' => 'Todo Deleted Successfully',
            'data' => null,
            'error' => null
        ]);
    }
}
