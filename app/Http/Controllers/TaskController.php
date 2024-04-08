<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Auth::user()->tasks()->latest()->get();
        return response()->json(['data' => $tasks, 'message' => 'Successfully retrieved data']);
    }

    /**
     * Store a newly created task for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @LRDparam description required|string|max:255
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $task = Auth::user()->tasks()->create($validatedData);

        return response()->json(['data' => $task, 'message' => 'Successfully stored task'], 201);
    }

    /**
     * Update the specified task for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @LRDparam description required|string|max:32
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
        ]);

        Gate::authorize('update', $task);

        $task->update($validatedData);

        return response()->json(['data' => $task, 'message' => 'Successfully updated task'], 200);
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);

        $task->delete();

        return response()->json(['message' => 'Successfully deleted task'], 200);
    }
}
