<div class="form-inline pull-right" id="company-filter-wrapper">
    <label class="control-label">{{ trans('admin::manager.form.filter') }}</label>
    <input id="company-filter" name="query" class="form-control" placeholder="{{ trans('admin::manager.form.filter') }}"
           data-filter-url="{{ route('admin::manager.filter') }}" value="{{ $filter }}"
           oninput="company.filter(this)" autofocus>
</div>