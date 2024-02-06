<?php

namespace App\Http\Controllers\API;

use App\Events\TaskUpdateEvent;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Notifications\TaskUpdated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class TaskController
 *
 * This class handles CRUD operations for tasks. It extends the BaseController for handling response formatting.
 *
 * @package App\Http\Controllers
 */
class TaskController extends BaseController
{
    /**
     * Display a listing of the tasks.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing a listing of tasks.
     */
    public function index(): JsonResponse
    {
        $tasks = Task::all();
        return $this->sendResponse($tasks, 'Tasks retrieved successfully.');
    }

    /**
     * Store a newly created task in storage.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request containing task data.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure of task creation.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Add user_id to the validated data using the authenticated user's id
        $validatedData = $validator->validated();
        $validatedData['user_id'] = Auth::id();

        // Create the task
        $task = Task::create($validatedData);

        // Return success response
        return $this->sendResponse($task, 'Task created successfully.');
    }

    /**
     * Display the specified task.
     *
     * @param  \App\Models\Task  $task  The task instance to be displayed.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the specified task.
     */
    public function show(Task $task): JsonResponse
    {
        return $this->sendResponse($task, '');
    }

    /**
     * Update the specified task in storage.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request containing updated task data.
     * @param  \App\Models\Task  $task  The task instance to be updated.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure of task update.
     */
    public function update(Request $request, Task $task): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Update the task with validated data
        $validatedData = $validator->validated();
        $task->update($validatedData);

        // Trigger the event
        event(new TaskUpdateEvent($task));
        // Dispatch the TaskUpdated notification to trigger the webhook
        Auth::user()->notify(new TaskUpdated($task));

        // Return success response
        return $this->sendResponse($task, 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  \App\Models\Task  $task  The task instance to be deleted.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success of task deletion.
     */
    public function destroy(Task $task): JsonResponse
    {
        // Delete the task
        $task->delete();

        // Return success response
        return $this->sendResponse([], 'Task deleted successfully.');
    }
}
