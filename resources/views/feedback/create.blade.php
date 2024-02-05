@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Create Task') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">

                        <form action="{{ route('task.store') }}" method="POST">
                            @csrf

                            <div class="card-body">
                                <label for="title">Title</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="title"
                                           class="form-control @error('title') is-invalid @enderror"
                                           placeholder="{{ __('Title') }}" value="{{ old('title') }}" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-heading"></span>
                                        </div>
                                    </div>
                                    @error('title')
                                    <span class="error invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                                <label for="description">Description</label>
                                <div class="input-group mb-3">
                                    <textarea name="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="{{ __('Description') }}"
                                              required>{{ old('description') }}</textarea>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-align-left"></span>
                                        </div>
                                    </div>
                                    @error('description')
                                    <span class="error invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                                <label for="status">Status</label>
                                <div class="input-group mb-3">
                                    <select name="status" class="form-control @error('status') is-invalid @enderror"
                                            required>
                                        <option value="To Do" {{ old('status') == 'To Do' ? 'selected' : '' }}>
                                            To Do
                                        </option>
                                        <option
                                                value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>
                                            In Progress
                                        </option>
                                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>
                                            Completed
                                        </option>
                                    </select>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-check"></span>
                                        </div>
                                    </div>
                                    @error('status')
                                    <span class="error invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('Create Task') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection

@section('scripts')
    @if ($message = Session::get('success'))
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script>
            toastr.options = {
                "closeButton": true,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            toastr.success('{{ $message }}')
        </script>
    @endif
@endsection
