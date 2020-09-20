<?php
/** @var  \App\Models\Employee[] $employeesList */
/** @var  \App\Models\Employee $employee */
?>
@extends('layouts.dash')

@section('title')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Company {{ $company->name }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route(\App\Alias\Routes::DASHBOARD) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route(\App\Alias\Routes::COMPANIES) }}">Companies</a></li>
                    <li class="breadcrumb-item active">{{ $company->name }}</li>
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
                        <a href="{{ route(\App\Alias\Routes::COMPANIES) }}"><< Back</a>
                        <a href="{{ route(\App\Alias\Routes::COMPANY_EDIT,[$company->slug]) }}" type="button"
                           title="Edit" class="float-right">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                    <div class="card-body">


                        <div class="row">
                            <div class="col-auto">
                                <div class="text-center">
                                    <img src="{{ $company->logo_full_path }}" style="max-width: 150px;"
                                         class="img-thumbnail img-fluid" alt=" {{ $company->name }}">
                                </div>
                            </div>
                            <div class="col">
                                <div>
                                    <h5 class="card-title float-none clearfix"
                                        style="font-size: 2em">{{ $company->name }}</h5>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <i class="far fa-envelope"></i>
                                            <a href="mailTo:{{ $company->email }}">{{ $company->email }}</a>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-globe"></i>
                                            <a href="phone:{{ $company->website }}">{{ $company->website }}</a>
                                        </div>
                                    </div>
                                </div>

                                <div>

                                    <div class="mt-5">
                                        <h2 class="text-lg"> Employees
                                            <a href="{{ route(\App\Alias\Routes::EMPLOYEE_NEW, ['company' => $company->slug]) }}"
                                               class="btn btn-outline-secondary float-right m-1" tabindex="0"
                                               aria-controls="companies-table"
                                               type="button"><span><i class="fa fa-plus"></i> Create</span></a>
                                        </h2>

                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Joining</th>
                                            <th scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($employeesList as $employee)
                                            <tr>
                                                <td scope="row">{{ $employee->full_name }}</td>
                                                <td>
                                                    <a href="tel:{{ $employee->phone }}">{{ $employee->phone }}</a>
                                                </td>
                                                <td>
                                                    <a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a>
                                                </td>
                                                <td>{{ $employee->created_at->toFormattedDateString() }}</td>
                                                <td> @include('employee.dataTablesAction',['code'=> $employee->code])</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="float-right">
                                        {{ $employeesList->links() }}
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