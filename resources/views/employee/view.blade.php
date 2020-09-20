@extends('layouts.dash')

@section('title')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Employee {{ $employee->full_name }} <small
                            class="text-muted">{{ $employee->company->name }}</small>
                </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route(\App\Alias\Routes::DASHBOARD) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route(\App\Alias\Routes::EMPLOYEES) }}">Employees</a></li>
                    <li class="breadcrumb-item active">{{ $employee->name }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route(\App\Alias\Routes::EMPLOYEES) }}"><< Back</a>
                        <a href="{{ route(\App\Alias\Routes::EMPLOYEE_EDIT,[$employee->code]) }}" type="button"
                           title="Edit" class="float-right">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <div class="text-center">
                                    <img src="{{ $employee->company->logo_full_path }}" style="max-width: 150px;"
                                         class="img-thumbnail img-fluid" alt=" {{ $employee->company->name }}">
                                </div>
                            </div>
                            <div class="col">
                                <div>
                                    <h5 class="card-title float-none clearfix"
                                        style="font-size: 2em">{{ $employee->full_name }}</h5>
                                    @if($employee->company->id)
                                        <h6 class="card-subtitle mb-2 text-muted"> {{ $employee->company->name }}
                                            <a href="{{ route(\App\Alias\Routes::COMPANY_VIEW, [$employee->company->slug]) }}">
                                                <i class="fas fa-external-link-alt"></i> </a>
                                        </h6>
                                    @endif
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <i class="far fa-envelope"></i>
                                            <a href="mailTo:{{ $employee->email }}">{{ $employee->email }}</a>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-phone"></i>
                                            <a href="phone:{{ $employee->phone }}">{{ $employee->phone }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
@endpush