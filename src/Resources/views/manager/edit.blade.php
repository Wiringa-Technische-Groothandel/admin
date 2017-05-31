@extends('admin::master')

@section('document_start')
    @include('admin::manager.edit.add-modal')

    @include('admin::manager.edit.delete-modal')
@endsection

@section('before-content')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin::manager') }}">
                {{ trans('admin::manager.text.user_manager') }}
            </a>
        </li>
        <li class="active">{{ trans('admin::manager.text.edit_company') }}</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                <div class="card card-2">
                    <h2>{{ $company->getName() }}</h2>

                    <hr />

                    @include('admin::manager.edit.form')
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="card card-2">
                    <h2>{{ trans('admin::manager.text.accounts') }}</h2>

                    <hr />

                    <button class="btn btn-primary" data-toggle="modal" data-target="#add-account-modal">
                        {{ trans('admin::manager.text.create_account') }}
                    </button>

                    @include('admin::manager.edit.table')
                </div>
            </div>
        </div>
    </div>
@endsection