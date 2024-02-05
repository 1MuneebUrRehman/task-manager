@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tasks</h1>
                </div><!-- /.col -->
                @can(\App\Enums\PermissionsEnum::CREATE_TASKS)
                    <div class="col-sm-6">
                        <!-- Add the "Create Task" button here -->
                        <a href="{{ route('task.create') }}" class="btn btn-primary float-right">Create Task</a>
                    </div>
                @endcan
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-0">

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th> <!-- Add a new column for actions -->
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->description }}</td>
                                        <td>{{ $task->status }}</td>
                                        <td>
                                            @can(\App\Enums\PermissionsEnum::EDIT_TASKS)
                                                <!-- Edit button -->
                                                <a class="btn btn-info btn-sm"
                                                   href="{{ route('task.edit', $task->id) }}">Edit</a>
                                            @endcan

                                            @can(\App\Enums\PermissionsEnum::VIEW_TASKS)
                                                <!-- Preview button (if needed) -->
                                                <a class="btn btn-success btn-sm"
                                                   href="{{ route('task.show', $task->id) }}">Preview</a>
                                            @endcan

                                            @can(\App\Enums\PermissionsEnum::DELETE_TASKS)
                                                <!-- Delete button -->
                                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteModal{{ $task->id }}">Delete
                                                </button>
                                            @endcan
                                        </td>
                                    </tr>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1" role="dialog"
                                         aria-labelledby="deleteModal{{ $task->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModal{{ $task->id }}Label">Delete
                                                        Task</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this task?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                    <!-- Add your delete action (e.g., a form submission) here -->
                                                    <form action="{{ route('task.destroy', $task->id) }}" method="POST"
                                                          style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer clearfix">
                            {{ $tasks->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
