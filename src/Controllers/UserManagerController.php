<?php

namespace WTG\Admin\Controllers;

use Webpatser\Uuid\Uuid;
use Illuminate\Http\Request;
use WTG\Admin\Requests\CreateCompanyRequest;
use WTG\Admin\Requests\CreateAccountRequest;
use WTG\Admin\Requests\UpdateAccountRequest;
use WTG\Admin\Requests\UpdateCompanyRequest;
use WTG\Customer\Interfaces\CompanyInterface as Company;
use WTG\Customer\Interfaces\CustomerInterface as Customer;

/**
 * User manager controller.
 *
 * @package     WTG\Admin
 * @subpackage  Controllers
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class UserManagerController extends Controller
{
    const COMPANIES_PER_PAGE = 10;

    /**
     * The user management page.
     *
     * @param  Request  $request
     * @param  Company  $company
     * @return \Illuminate\View\View
     */
    public function view(Request $request, Company $company)
    {
        $filter = $request->input('filter');
        $companies = $company
            ->where('customer_number', 'LIKE', "%{$filter}%")
            ->orWhere('name', 'LIKE', "%{$filter}%")
            ->orderBy('customer_number', 'asc')
            ->paginate(static::COMPANIES_PER_PAGE);

        return view('admin::manager.index', compact('companies', 'filter'));
    }

    /**
     * Create a new company.
     *
     * @param  CreateCompanyRequest  $request
     * @param  Company  $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(CreateCompanyRequest $request, Company $company)
    {
        $company->setId(Uuid::generate(4));
        $company->setName($request->input('name'));
        $company->setCustomerNumber($request->input('customerNumber'));
        $company->setIsAdmin(false);
        $company->setActive(true);

        if ($company->save()) {
            return back()
                ->with('status', trans('admin::manager.text.company_creation_success'));
        } else {
            return back()
                ->withErrors(trans('admin::manager.text.company_creation_error'))
                ->withInput($request->input());
        }
    }

    /**
     * Edit company page.
     *
     * @param  Request  $request
     * @param  string  $companyId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, Company $company, string $companyId)
    {
        $company = $company->find($companyId);

        if ($company === null) {
            return back()
                ->withErrors(trans('admin::manager.text.company_not_found', ['id' => $companyId]));
        }

        return view('admin::manager.edit', compact('company'));
    }

    /**
     * Update a company.
     *
     * @param  UpdateCompanyRequest  $request
     * @param  Company  $company
     * @param  string  $companyId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCompanyRequest $request, Company $company, string $companyId)
    {
        /** @var Company $company */
        $company = $company->find($companyId);

        if ($company === null) {
            return back()
                ->withErrors(trans('admin::manager.text.company_not_found', ['id' => $companyId]));
        }

        $company->setCustomerNumber($request->input('customerNumber'));
        $company->setName($request->input('name'));
        $company->save();

        return back()
            ->with('status', trans('admin::manager.text.company_update_success'));
    }

    /**
     * Create a new account for a company.
     *
     * @param  CreateAccountRequest  $request
     * @param  Company  $company
     * @param  Customer  $customer
     * @param  string  $companyId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAccount(CreateAccountRequest $request, Company $company, Customer $customer, string $companyId)
    {
        /** @var Company $company */
        $company = $company->find($companyId);

        if ($company === null) {
            return back()
                ->withErrors(trans('admin::manager.text.company_not_found', ['id' => $companyId]))
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        // Random pre-generated password
        $password = $request->input('password') ?: str_random(12);

        // Make it the main account if it's the first account
        $mainAccount = ($company->getCustomers()->count() === 0);

        $customer->setId(Uuid::generate(4));
        $customer->setCompanyId($company->getId());
        $customer->setUsername($request->input('username'));
        $customer->setPassword(bcrypt($password));
        $customer->setEmail($request->input('email'));
        $customer->setActive($request->input('active', false));
        $customer->setManager($request->input('manager', $mainAccount));
        $customer->setIsMain($mainAccount);

        if ($customer->save()) {
            $request->session()->flash($customer->getId().'_password', $password);

            return back()
                ->with('status', trans('admin::manager.text.account_create_success'));
        } else {
            return back()
                ->withErrors(trans('admin::manager.text.account_create_error'))
                ->withInput($request->except(['password', 'password_confirmation']));
        }
    }

    /**
     * Delete a customer.
     *
     * @param  Request  $request
     * @param  Company  $company
     * @param  Customer  $customer
     * @param  string  $companyId
     * @param  string  $customerId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAccount(Request $request, Company $company, Customer $customer, string $companyId, string $customerId)
    {
        /** @var Company $company */
        $company = $company->find($companyId);

        if ($company === null) {
            return back()
                ->withErrors(trans('admin::manager.text.company_not_found', ['id' => $companyId]));
        }

        /** @var Customer $customer */
        $customer = $customer->find($customerId);

        if ($customer === null) {
            return back()
                ->withErrors(trans('admin::manager.text.account_not_found', ['id' => $customerId]));
        }

        if ($customer->getIsMain()) {
            return back()
                ->withErrors(trans('admin::manager.text.main_account_delete_error'));
        }

        $customer->delete();

        return redirect()
            ->route('admin::manager.edit', ['companyId' => $company->getId()])
            ->with('status', trans('admin::manager.text.account_delete_success'));
    }

    /**
     * Edit an account.
     *
     * @param  Request  $request
     * @param  Company  $company
     * @param  Customer  $customer
     * @param  string  $companyId
     * @param  string  $customerId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function editAccount(Request $request, Company $company, Customer $customer, string $companyId, string $customerId)
    {
        /** @var Company $company */
        $company = $company->find($companyId);

        if ($company === null) {
            return back()
                ->withErrors(trans('admin::manager.text.company_not_found', ['id' => $companyId]));
        }

        /** @var Customer $customer */
        $customer = $customer->find($customerId);

        if ($customer === null) {
            return back()
                ->withErrors(trans('admin::manager.text.account_not_found', ['id' => $customerId]));
        }

        return view('admin::manager.edit-account', compact('company', 'customer'));
    }

    /**
     * Update an account.
     *
     * @param  UpdateAccountRequest  $request
     * @param  Company  $company
     * @param  Customer  $customer
     * @param  string  $companyId
     * @param  string  $customerId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAccount(UpdateAccountRequest $request, Company $company, Customer $customer, string $companyId, string $customerId)
    {
        /** @var Company $company */
        $company = $company->find($companyId);

        if ($company === null) {
            return back()
                ->withErrors(trans('admin::manager.text.company_not_found', ['id' => $companyId]));
        }

        /** @var Customer $customer */
        $customer = $customer->find($customerId);

        if ($customer === null) {
            return back()
                ->withErrors(trans('admin::manager.text.account_not_found', ['id' => $customerId]));
        }

        if ($request->input('password') !== "") {
            $customer->setPassword(bcrypt($request->input('password')));
        }

        $customer->setUsername($request->input('username'));
        $customer->setEmail($request->input('email'));
        $customer->setActive($request->input('active', false));
        $customer->setManager($request->input('manager', false));

        if ($customer->save()) {
            return back()
                ->with('status', trans('admin::manager.account_edit_success'));
        } else {
            return back()
                ->withErrors(trans('admin::manager.account_edit_error'))
                ->withInput($request->except(['password', 'password_confirmation']));
        }
    }

    /**
     * Remove a company from the system.
     *
     * @param  Request  $request
     * @param  Company  $company
     * @param  string  $companyId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Company $company, string $companyId)
    {
        /** @var Company $company */
        $company = $company->find($companyId);

        if ($company === null) {
            return back()
                ->withErrors(trans('admin::manager.text.company_not_found', ['id' => $companyId]));
        }

        if ($company->getId() === auth()->user()->getCompanyId()) {
            return back()
                ->withErrors(trans('admin::manager.text.remove_current_company_error'));
        }

        // Remove the accounts
        $company->getCustomers()->each(function ($customer) {
            /** @var Customer $customer */
            $customer->delete();
        });

        // Delete the company
        $company->delete();

        return redirect()
            ->route('admin::manager')
            ->with('status', trans('admin::manager.text.company_deleted'));
    }

    /**
     * Filter the companies list.
     *
     * @param  Request  $request
     * @param  Company  $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request, Company $company)
    {
        $filter = $request->input('filter');
        $companies = $company
            ->where('customer_number', 'LIKE', "%{$filter}%")
            ->orWhere('name', 'LIKE', "%{$filter}%")
            ->orderBy('customer_number', 'asc')
            ->paginate(static::COMPANIES_PER_PAGE)
            ->withPath(route('admin::manager'));

        return response()->json([
            'message' => trans('admin::manager.text.companies_filter_results'),
            'payload' => view('admin::manager.index.table', compact('companies', 'filter'))->render()
        ]);
    }
}
