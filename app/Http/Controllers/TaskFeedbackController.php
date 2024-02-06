<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskFeedback;
use Illuminate\Http\Request;

/**
 * Class TaskFeedbackController
 *
 * This class manages the creation of feedback for tasks.
 * It allows storing feedback related to a specific task in the storage.
 *
 * @package App\Http\Controllers
 */
class TaskFeedbackController extends Controller
{
    /**
     * Store a newly created feedback for a task in storage.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request containing feedback data.
     * @param  \App\Models\Task  $task  The task instance for which feedback is provided.
     *
     * @return \Illuminate\Contracts\View\View A view for displaying the list of feedback related to the task.
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

        return view('feedback.feedback_list')->with('task', $task);
    }
}
