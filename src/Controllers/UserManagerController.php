<?php

namespace WTG\Admin\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Webpatser\Uuid\Uuid;
use Illuminate\Http\Request;
use WTG\Admin\Requests\CreateCompanyRequest;
use WTG\Admin\Requests\CreateAccountRequest;
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
    public function edit(Request $request, string $companyId)
    {
        $company = app()
            ->make(Company::class)
            ->find($companyId);

        if ($company === null) {
            return back()
                ->withErrors(trans('admin::manager.text.company_not_found', ['id' => $companyId]));
        }

        return view('admin::manager.edit', compact('company'));
    }

    public function update(Request $request, string $companyId)
    {
        /** @var Company $company */
        $company = app()
            ->make(Company::class)
            ->find($companyId);

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
     * @param  Customer  $customer
     * @param  string  $companyId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAccount(CreateAccountRequest $request, Customer $customer, string $companyId)
    {
        /** @var Company $company */
        $company = app()
            ->make(Company::class)
            ->find($companyId);

        if ($company === null) {
            return back()
                ->withErrors(trans('admin::manager.text.company_not_found', ['id' => $companyId]))
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        // Random pre-generated password
        $password = $request->input('password') ?: str_random(12);

        $customer->setId(Uuid::generate(4));
        $customer->setCompanyId($company->getId());
        $customer->setUsername($request->input('username'));
        $customer->setPassword(bcrypt($password));
        $customer->setEmail($request->input('email'));
        $customer->setManager($request->input('manager', false));
        $customer->setActive($request->input('active', false));
        $customer->setIsMain($company->getCustomers()->count() === 0); // Make it the main account if it's the only one

        if ($customer->save()) {
            $request->session()->flash($customer->getId().'_password', $password);

            return back()
                ->with('status', trans('admin::manager.text.account_creation_success'));
        } else {
            return back()
                ->withErrors(trans('admin::manager.text.account_creation_error'))
                ->withInput($request->except(['password', 'password_confirmation']));
        }
    }

    /**
     * Remove a company from the system.
     *
     * @param  Request  $request
     * @param  string  $companyId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, string $companyId)
    {
        /** @var Company $company */
        $company = app()
            ->make(Company::class)
            ->find($companyId);

        if ($company === null) {
            return back()
                ->withErrors(trans('admin::manager.text.company_not_found', ['id' => $companyId]));
        }

        if ($company->getId() === auth()->id()) {
            return back()
                ->withErrors(trans('admin::manager.text.remove_current_company_error'));
        }

        // Remove the accounts
        $company->getCustomers()->each(function ($account) {
            /** @var $account Customer */
            $account->delete();
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

    /**
     * Get some user details.
     *
     * TODO: Rewrite for the new customer module
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        dd('Rewrite!');

        if ($request->has('id')) {
            $company = Company::with('mainUser')->where('login', $request->input('id'))->first();

            if ($company !== null) {
                return response()->json([
                    'message' => 'User details for user '.$company->login,
                    'payload' => $company,
                ]);
            } else {
                return response()->json([
                    'message' => 'No user found with login '.$request->input('id'),
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Missing request parameter: `id`',
            ], 400);
        }
    }

    /**
     * Show the user added page.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function added()
    {
        if (\Session::has('password') && \Session::has('input')) {
            return view('admin.user.added')
                ->with([
                    'password' => \Session::pull('password'),
                    'input' => \Session::get('input'),
                ]);
        } else {
            return redirect()
                ->route('admin.user::manager');
        }
    }

    /**
     * Remove a user
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function wdwd(Request $request)
    {
        if (!$request->has('company_id')) {
            return redirect()
                ->back()
                ->withInput($request->input())
                ->withErrors('Geen debiteurnummer opgegeven');
        }

        // Get the company
        $company = Company::whereLogin($request->input('company_id'))->first();

        if ($company) {
            // Remove associated users
            $company->users->each(function ($user) {
                $user->delete();
            });

            // Remove the company
            $company->delete();

            return redirect()
                ->back()
                ->with('status', 'Het bedrijf en bijbehorende gegevens zijn verwijderd');
        } else {
            return redirect()
                ->back()
                ->withInput($request->input())
                ->withErrors('Geen bedrijf gevonden met login naam '.$request->input('company_id'));
        }
    }

    /**
     * Add/update a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updat123e(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'company_id'   => 'required|integer|between:10000,99999',
            'company_name' => 'required|string',

            'address'  => 'required',
            'postcode' => 'required',
            'city'     => 'required',

            'email'  => 'required|email',
            'active' => 'required',
        ]);

        if ($validator->passes()) {
            if ($company = Company::whereLogin($request->input('company_id'))->first()) {
                $company->login = $request->input('company_id');
                $company->company = $request->input('company_name');
                $company->street = $request->input('address');
                $company->postcode = $request->input('postcode');
                $company->city = $request->input('city');
                $company->active = $request->input('active');

                $company->save();

                \Log::info('Company '.$company->login.' has been updated by an admin');

                $user = $company->mainUser;

                $user->username = $request->input('company_id');
                $user->company_id = $request->input('company_id');
                $user->email = $request->input('email');

                $user->save();

                \Log::info('User '.$user->username.' has been updated by an admin');

                return redirect()
                    ->back()
                    ->with('status', 'Bedrijf '.$company->company_id.' is aangepast');
            } else {
                $pass = mt_rand(100000, 999999);

                $company = new Company();

                $company->login = $request->input('company_id');
                $company->company = $request->input('company_name');
                $company->street = $request->input('address');
                $company->postcode = $request->input('postcode');
                $company->city = $request->input('city');
                $company->active = $request->input('active');

                $company->save();

                $user = new User();

                $user->username = $request->input('company_id');
                $user->company_id = $request->input('company_id');
                $user->email = $request->input('email');
                $user->manager = true;
                $user->password = bcrypt($pass);

                $user->save();

                \Session::flash('password', $pass);
                \Session::flash('input', $request->all());

                return redirect()
                    ->route('admin.user::added');
            }
        } else {
            return redirect()
                ->back()
                ->withInput($request->input())
                ->withErrors($validator->errors());
        }
    }
}
