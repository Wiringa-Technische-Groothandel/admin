@extends('admin::master')

@section('before-content')
    <div class="hidden-sm hidden-xs">
        @include('admin::components.pre-content')
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <div class="card card-2">
                    @include('admin::dashboard.components.product-import')
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card card-2">
                    @include('admin::dashboard.components.discount-import')
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8">
                <div class="card card-2">
                    @include('admin::dashboard.components.order-chart')
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card card-2">
                    @include('admin::dashboard.components.server-stats')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('document_end')
    @include('admin::dashboard.components.javascript')
@endsection