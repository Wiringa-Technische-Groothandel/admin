<?php

namespace WTG\Admin\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Create account request.
 *
 * @package     WTG\Admin
 * @subpackage  Requests
 * @author      Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class CreateAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email" => ['required'],
            "username" => ['required', 'max:20', Rule::unique('customers')->where(function ($query) { $query->where('company_id', $this->route('companyId')); })],
            'password' => ['confirmed']
        ];
    }
}