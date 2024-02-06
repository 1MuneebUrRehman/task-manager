<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskFeedback;
use Illuminate\Http\Request;

class TaskFeedbackController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'feedback' => 'required',
        ]);

        TaskFeedback::create([
            'task_id' => $task->id,
            'comment' => $request->input('feedback'),
        ]);

        return redirect()->route('task.show', $task->id)
            ->with('success', 'Feedback added successfully.');
    }

}
