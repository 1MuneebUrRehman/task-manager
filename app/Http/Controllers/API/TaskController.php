<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Notifications\TaskUpdated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $tasks = Task::all();
        return $this->sendResponse($tasks, 'Tasks retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Unauthorised.',
                ['error' => $validator->errors()]);
        }

        $validatedData = $validator->validated();
        $validatedData['user_id'] = Auth::id();

        $task = Task::create($validatedData);

        return $this->sendResponse($task, 'Task created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): JsonResponse
    {
        return $this->sendResponse($task, '');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $validatedData = $validator->validated();
        $task->update($validatedData);

        // Dispatch the TaskUpdated notification to trigger the webhook
        $task->notify(new TaskUpdated($task));

        return $this->sendResponse($task, 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return $this->sendResponse([], 'Task deleted successfully.');
    }
}