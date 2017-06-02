<?php

namespace WTG\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Update company request.
 *
 * @package     WTG\Admin
 * @subpackage  Requests
 * @author      Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class UpdateCompanyRequest extends FormRequest
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
            "customerNumber" => ['required'],
            "name" => ['required']
        ];
    }
}