@extends('admin::master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="card card-2">
                    @include('admin::manager.index.create')

                    <hr />

                    @include('admin::manager.index.search')

                    @include('admin::manager.index.table')

                    @if ($companies->count())
                        {{ $companies->render() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection