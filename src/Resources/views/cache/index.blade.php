@extends('admin::master')

@section('document_start')
    @if($opcache_enabled)
        @include('admin::cache.components.modal')
    @endif
@endsection

@section('content')
    @if(!$opcache_enabled)
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="card card-2">
                        <h3><i class="fa fa-fw fa-close"></i> Opcache disabled</h3>

                        <hr />

                        <p>
                            De PHP module 'opcache' staat niet aan. <br />
                            Deze kan worden geactiveerd via de PHP configuratie op de server.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-md-8 col-md-offset-2">
                    <div class="card card-2">
                        <button data-target="#resetCacheModal" data-toggle="modal" class="btn btn-danger btn-block">Reset cache</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-4 col-md-offset-2">
                    <div class="card card-2">
                        @include('admin::cache.components.memory-chart')
                    </div>
                </div>

                <div class="col-xs-6 col-md-4">
                    <div class="card card-2">
                        @include('admin::cache.components.hitrate-chart')
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-8 col-md-offset-2">
                    <div class="card card-2">
                        @include('admin::cache.components.information')
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('document_end')
    @if($opcache_enabled)
        @include('admin::cache.components.javascript')
    @endif
@endsection