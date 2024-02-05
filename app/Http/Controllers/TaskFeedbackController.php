<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskFeedback;
use Illuminate\Http\Request;

class TaskFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Task $task)
    {
        return view('feedback.create', compact('task'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $taskFeedback = TaskFeedback::create([
            'task_id' => $task->id,
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('tasks.show', $task->id)
            ->with('success', 'Feedback added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskFeedback $taskFeedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskFeedback $taskFeedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskFeedback $taskFeedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskFeedback $taskFeedback)
    {
        //
    }
}
