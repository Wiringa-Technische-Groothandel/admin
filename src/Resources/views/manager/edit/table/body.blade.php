@forelse($company->getCustomers()->sortByDesc('created_at') as $account)
    <?php /** @var $account \WTG\Customer\Interfaces\CustomerInterface */ ?>
    <tr>
        <td>{{ $account->getUsername() }}</td>
        <td>{{ $account->getEmail() }}</td>
        <td>{{ session($account->getId().'_password') ? trans('admin::manager.text.password_shown_warning', ['password' => session($account->getId().'_password')]) : trans('admin::manager.text.password_hidden') }}</td>
        <td class="hidden-xs">{{ $account->getActive() ? trans('admin::manager.form.active') : trans('admin::manager.form.inactive') }}</td>
        <td class="hidden-xs">{{ $account->getManager() ? trans('admin::manager.form.yes') : trans('admin::manager.form.no') }}</td>
        <td class="edit-button">
            <a href="{{ route('admin::manager.edit', ['companyId' => $account->getCompanyId(), 'accountId' => $account->getId()]) }}" class="btn btn-link">
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