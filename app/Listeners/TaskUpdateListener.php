<?php

namespace App\Listeners;

use App\Events\TaskUpdateEvent;
use Illuminate\Support\Facades\Log;

class TaskUpdateListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskUpdateEvent $event): void
    {
        $task = $event->task;

        Log::info('Task ('.$task['id'].') Updated Successfully....');
    }
}
