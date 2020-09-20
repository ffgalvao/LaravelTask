@extends('layouts.dash')

@section('title')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Editing employee</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route(\App\Alias\Routes::DASHBOARD) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route(\App\Alias\Routes::EMPLOYEES) }}">Employees</a></li>
                    <li class="breadcrumb-item"><a href="{{ route(\App\Alias\Routes::EMPLOYEE_VIEW,[$employee->code]) }}">
                            {{ $employee->full_name }}</a></li>
                    <li class="breadcrumb-item active">Editing</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <a href="javascript:window.history.go(-1);"><< Back</a>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">{{ $employee->full_name }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route(\App\Alias\Routes::EMPLOYEE_EDIT, [$employee->code]) }}"
                                  method="post">
                                @csrf @method('PUT')
                                @include('employee._form')
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection

@push('style')
@endpush
@push('scripts')
    <script>
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@endpush