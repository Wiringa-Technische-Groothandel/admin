@forelse($company->getCustomers()->sortByDesc('created_at') as $customer)
    <?php /** @var $customer \WTG\Customer\Interfaces\CustomerInterface */ ?>
    <tr>
        <td>{{ $customer->getUsername() }}</td>
        <td>{{ $customer->getEmail() }}</td>
        <td>{{ session($customer->getId().'_password') ? trans('admin::manager.text.password_shown_warning', ['password' => session($customer->getId().'_password')]) : trans('admin::manager.text.password_hidden') }}</td>
        <td class="hidden-xs">{{ $customer->getActive() ? trans('admin::manager.form.active') : trans('admin::manager.form.inactive') }}</td>
        <td class="hidden-xs">{{ $customer->getManager() ? trans('admin::manager.form.yes') : trans('admin::manager.form.no') }}</td>
        <td class="edit-button">
            <a href="{{ route('admin::manager.edit-account', ['companyId' => $customer->getCompanyId(), 'customerId' => $customer->getId()]) }}" class="btn btn-link">
                <i class="fa fa-fw fa-edit"></i>
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7">
            <div class="alert alert-warning">
                {{ trans('admin::manager.text.no_accounts') }}
            </div>
        </td>
    </tr>
@endforelse