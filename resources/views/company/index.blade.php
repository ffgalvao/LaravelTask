@extends('layouts.dash')

@section('title')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Companies List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route(\App\Alias\Routes::DASHBOARD) }}">Home</a></li>
                    <li class="breadcrumb-item active">Companies</li>
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
                    <div class="card-body">
                        <div class="p-1">
                        <a href="{{ route(\App\Alias\Routes::COMPANY_NEW) }}" class="btn btn-outline-secondary float-left" tabindex="0" aria-controls="companies-table" type="button"><span><i class="fa fa-plus"></i> Create</span></a>
                        </div>
                        {{$dataTable->table()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection

@push('style')
    <style>
        table.dataTable td, table.dataTable th {
            vertical-align: middle;
        }
    </style>
@endpush
@push('scripts')
    {{$dataTable->scripts()}}
@endpush