@extends('admin::master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <div class="card card-2">
                    <h3>
                        <i class="fa fa-check-circle-o fa-fw" aria-hidden="true"></i> {{ __('Import success') }}
                    </h3>

                    <hr />

                    <a class="btn btn-default" href="{{ route('admin.import') }}">
                        <span class="glyphicon glyphicon-chevron-left"></span> {{ __('Back to the import page') }}
                    </a>

                    <div class="text-center">
                        @if (session('type') === 'afbeelding' || session('type') === 'download')
                            <h4>De {{ session('type') }} import is gelukt. Er {{ (session('count') === 1 ? 'is' : 'zijn') }} {{ session('count') }} {{ session('type') }}{{ (session('count') === 1 ? '' : 'en') }} geimporteerd in {{ session('time')}} seconden.</h4>
                        @else
                            <h4>De {{ session('type') }} upload is gelukt. De import wordt uitgevoerd over {{ app('helper')->timeToNextCronJob() }} minuten.</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection