<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //
    /**
     * Display a listing of the tasks for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Auth::user()->tasks()->latest()->get();
        return response()->json(['data' => $tasks]);
    }

    /**
     * Store a newly created task for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $task = Auth::user()->tasks()->create($validatedData);

        return response()->json($task, 201);
    }

    /**
     * Update the specified task for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $this->authorize('update', $task);

        $task->update($validatedData);

        return response()->json($task, 200);
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully'], 200);
    }
}
