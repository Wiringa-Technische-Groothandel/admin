@forelse($companies as $company)
    <?php /** @var $company \WTG\Customer\Interfaces\CompanyInterface */ ?>
    <tr>
        <td>{{ $company->getCustomerNumber() }}</td>
        <td class="company-name">{{ $company->getName() }}</td>
        <td class="hidden-xs">{{ $company->getActive() ? trans('admin::manager.form.active') : trans('admin::manager.form.inactive') }}</td>
        <td class="hidden-xs">{{ $company->getCreatedAt('d-m-Y') }}</td>
        <td class="edit-button">
            <a href="{{ route('admin::manager.edit', ['companyId' => $company->getId()]) }}" class="btn btn-link">
                <i class="fa fa-fw fa-edit"></i>
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6">
            <div class="alert alert-warning">
                {{ trans('admin::manager.text.no_companies') }}
            </div>
        </td>
    </tr>
@endforelse