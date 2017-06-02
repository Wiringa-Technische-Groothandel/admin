@extends('admin::master')

@section('before-content')
    <ol class="breadcrumb">
        <li class="active">{{ trans('admin::manager.text.user_manager') }}</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="card card-2">
                    @include('admin::manager.index.create')

                    <hr />

                    @include('admin::manager.index.search')

                    @include('admin::manager.index.table')
                </div>
            </div>
        </div>
    </div>
@endsection