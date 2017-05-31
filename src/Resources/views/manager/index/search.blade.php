<form class="form-inline pull-right" id="company-search-form">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="query">{{ trans('admin::manager.text.search') }}</label>
        <input type="text" name="query" class="form-control" placeholder="Naam of nummer" autofocus>
    </div>

    <button type="submit" class="btn btn-primary">{{ trans('admin::manager.text.search') }}</button>
</form>