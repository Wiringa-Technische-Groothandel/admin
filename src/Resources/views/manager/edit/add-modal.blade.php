<form class="form form-horizontal" method="post" id="add-account-form" action="{{ route('admin::manager.create-account', ['companyId' => $company->getId()]) }}">
    {{ csrf_field() }}
    {{ method_field('put') }}

    <div class="modal fade" tabindex="-1" role="dialog" id="add-account-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('admin::manager.text.create_account') }}</h4>
                </div>
                <div class="modal-body">
                    {{-- Form fields only, modal is already wrapped in a form tag --}}
                    @include('admin::manager.edit.add-modal.form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin::manager.form.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('admin::manager.form.save') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>