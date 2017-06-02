<form method="post" action="{{ route('admin::manager.create') }}" class="form-inline" id="company-create-form">
    {{ csrf_field() }}
    {{ method_field('put') }}

    <div class="form-group">
        <input type="text" name="customerNumber" class="form-control" placeholder="Debiteurnummer">
    </div>

    <div class="form-group">
        <input type="text" name="name" class="form-control" placeholder="Naam">
    </div>

    <button type="submit" class="btn btn-success">
        {{ trans('admin::manager.text.create_company') }}
    </button>
</form>