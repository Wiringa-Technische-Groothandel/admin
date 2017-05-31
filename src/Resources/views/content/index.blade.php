@extends('admin::master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="card card-2">
                    @include('admin::content.components.page-editor')
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="card card-2">
                    @include('admin::content.components.product-editor')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('document_end')
    @include('admin::content.components.javascript')
@endsection