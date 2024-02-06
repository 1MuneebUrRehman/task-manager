@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <span class="text-capitalize">Task</span>
                        <a href="{{ route('task.index') }}" class="ml-3 text-sm">
                            <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                            Back to all
                            <span>tasks</span>
                        </a>
                    </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card no-padding no-border">
                        <table class="table table-striped mb-0">
                            <tbody>
                            <tr>
                                <td>
                                    <strong>User:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $task->user->name }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Title:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $task->title }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Description:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $task->description }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Actions:</strong>
                                </td>
                                <td>
                                    @can(\App\Enums\PermissionsEnum::EDIT_TASKS)
                                        <!-- Edit button -->
                                        <a href="{{ route('task.edit', $task->id) }}"
                                           class="btn btn-info btn-sm">Edit</a>
                                    @endcan
                                    @can(\App\Enums\PermissionsEnum::DELETE_TASKS)
                                        <!-- Delete button with confirmation popup -->
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteModal">Delete
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Feedback Listing Section -->
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>Feedbacks</h3>
                        </div>
                        <div class="card-body">
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
                                <p>No feedback available
                                    @endif
                                </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Feedback Form Section -->
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>Provide Feedback</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('feedback.store', $task->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="feedback">Your Feedback:</label>
                                    <textarea name="feedback" id="feedback" class="form-control" rows="3"
                                              required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Feedback</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can(\App\Enums\PermissionsEnum::DELETE_TASKS)
        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this task?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- Add your delete action (e.g., a form submission) here -->
                        <form action="{{ route('task.destroy', $task->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan

@endsection
