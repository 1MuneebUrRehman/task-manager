@if($task->feedbacks && $task->feedbacks->count() > 0)
    <ul class="list-group">
        @foreach($task->feedbacks as $feedback)
            <li class="list-group-item">
                <strong>User:</strong> {{ $feedback->task->user->name }}
                <br>
                <strong>Feedback:</strong> {{ $feedback->comment }}
            </li>
        @endforeach
    </ul>
@else
    <p>No feedback available</p>
@endif
