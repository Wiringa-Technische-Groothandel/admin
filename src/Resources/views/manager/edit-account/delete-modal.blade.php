<form class="form form-horizontal" method="post" id="delete-account-form" action="{{ route('admin::manager.delete-account', ['companyId' => $company->getId(), 'customerId' => $customer->getId()]) }}">
    {{ csrf_field() }}
    {{ method_field('delete') }}

    <div class="modal fade" tabindex="-1" role="dialog" id="delete-account-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('admin::manager.text.delete_account_warning', ['username' => $customer->getUsername()]) }}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin::manager.form.close') }}</button>
                    <button type="submit" class="btn btn-danger">{{ trans('admin::manager.form.delete') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>