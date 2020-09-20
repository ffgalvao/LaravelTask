@extends('layouts.dash')

@section('title')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Creating a company</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route(\App\Alias\Routes::DASHBOARD) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route(\App\Alias\Routes::COMPANIES) }}">Companies</a></li>
                    <li class="breadcrumb-item active">Creating</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <a href="{{ route(\App\Alias\Routes::COMPANIES) }}"><< Back</a>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Company</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route(\App\Alias\Routes::COMPANY_SAVE) }}" method="post" enctype="multipart/form-data">
                            @include('company._form')
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
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endpush