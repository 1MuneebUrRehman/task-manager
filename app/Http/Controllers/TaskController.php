<?php

namespace App\Http\Controllers;

use App\Enums\PermissionsEnum;
use App\Models\Task;
use App\Notifications\TaskUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize(PermissionsEnum::VIEW_TASKS);

        $tasks = Task::all();
        return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize(PermissionsEnum::CREATE_TASKS);

        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize(PermissionsEnum::CREATE_TASKS);

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
        ]);

        $validatedData['user_id'] = Auth::id();
        Task::create($validatedData);

        return redirect()->route('task.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize(PermissionsEnum::VIEW_TASKS);

        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize(PermissionsEnum::EDIT_TASKS);

        return view('task.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize(PermissionsEnum::EDIT_TASKS);

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
        ]);

        $task->update($validatedData);

        // Dispatch the TaskUpdated notification to trigger the webhook
        $task->notify(new TaskUpdated($task));

        return redirect()->route('task.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize(PermissionsEnum::DELETE_TASKS);

        $task->delete();

        return redirect()->route('task.index')->with('success', 'Task deleted successfully.');
    }
}
