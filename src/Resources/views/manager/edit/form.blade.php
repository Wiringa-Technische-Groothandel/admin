<form class="form form-horizontal" method="post">
    {{ csrf_field() }}
    {{ method_field('patch') }}

    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">{{ trans('admin::manager.form.customer_number') }}</label>
        <div class="col-sm-9">
            <input placeholder="{{ trans('admin::manager.form.customer_number') }}" name="customerNumber"
                   value="{{ old('customerNumber', $company->getCustomerNumber()) }}" class="form-control" />
        </div>
    </div>

    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">{{ trans('admin::manager.form.name') }}</label>
        <div class="col-sm-9">
            <input placeholder="{{ trans('admin::manager.form.name') }}" name="name"
                   value="{{ old('name', $company->getName()) }}" class="form-control" />
        </div>
    </div>

    <br />

    <div class="form-group">
        <div class="col-sm-3">
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-company-modal">
                {{ trans('admin::manager.form.delete') }}
            </button>
        </div>
        <div class="col-sm-9">
            <button type="submit" class="btn btn-success">{{ trans('admin::manager.form.save') }}</button>
        </div>
    </div>
</form>