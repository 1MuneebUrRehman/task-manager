@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <span class="text-capitalize">Role</span>
                        <a href="{{ route('roles.index') }}" class="ml-3 text-sm">
                            <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                            Back to all
                            <span>roles</span>
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
                        <form action="{{ route('role.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <table class="table table-striped mb-0">
                                <tbody>
                                <tr>
                                    <td>
                                        <strong>Name:</strong>
                                    </td>
                                    <td>
                                        <span>{{ $role->name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Permissions:</strong>
                                    </td>
                                    <td>
                                        @foreach($permissions as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]"
                                                       value="{{ $permission->name }}" {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mt-3">Update Permissions</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
