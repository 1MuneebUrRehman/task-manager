<?php

namespace App\Http\Controllers;

use App\Enums\PermissionsEnum;
use App\Events\TaskUpdateEvent;
use App\Models\Task;
use App\Notifications\TaskUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class TaskController
 *
 * This class manages CRUD operations for tasks, including displaying, creating, updating, and deleting tasks.
 * It extends the Laravel Controller class.
 *
 * @package App\Http\Controllers
 */
class TaskController extends Controller
{
    /**
     * Display a listing of tasks.
     *
     * @return \Illuminate\Contracts\View\View A view containing a listing of tasks.
     */
    public function index()
    {
        $this->authorize(PermissionsEnum::VIEW_TASKS);

        $tasks = Task::paginate(5);
        return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     *
     * @return \Illuminate\Contracts\View\View A view for creating a new task.
     */
    public function create()
    {
        $this->authorize(PermissionsEnum::CREATE_TASKS);

        return view('task.create');
    }

    /**
     * Store a newly created task in storage.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request containing task data.
     *
     * @return \Illuminate\Http\RedirectResponse A redirect response indicating success or failure of task creation.
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
     * Display the specified task.
     *
     * @param  \App\Models\Task  $task  The task instance to be displayed.
     * @return \Illuminate\Contracts\View\View A view containing details of the specified task.
     */
    public function show(Task $task)
    {
        $this->authorize(PermissionsEnum::VIEW_TASKS);

        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     *
     * @param  \App\Models\Task  $task  The task instance to be edited.
     * @return \Illuminate\Contracts\View\View A view for editing the specified task.
     */
    public function edit(Task $task)
    {
        $this->authorize(PermissionsEnum::EDIT_TASKS);

        return view('task.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request containing updated task data.
     * @param  \App\Models\Task  $task  The task instance to be updated.
     * @return \Illuminate\Http\RedirectResponse A redirect response indicating success or failure of task update.
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

        // Trigger the event
        event(new TaskUpdateEvent($task));
        // Dispatch the TaskUpdated notification to trigger the webhook
        Auth::user()->notify(new TaskUpdated($task));

        return redirect()->route('task.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  \App\Models\Task  $task  The task instance to be deleted.
     * @return \Illuminate\Http\RedirectResponse A redirect response indicating success or failure of task deletion.
     */
    public function destroy(Task $task)
    {
        $this->authorize(PermissionsEnum::DELETE_TASKS);

        $task->delete();

        return redirect()->route('task.index')->with('success', 'Task deleted successfully.');
    }
}
