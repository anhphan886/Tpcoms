<?php

namespace Modules\Product\Http\Requests\customerChildAccount;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'account_name' => 'required|max:255',
            'account_type' => 'required',
            'email' => 'required|email|unique:customer_account,account_email,' . ',customer_account_id,is_deleted,0',
            'password' => 'required|max:20|min:8',
            'account_phone' => 'required|max:11|min:10|unique:customer_account,account_phone,' . ',customer_account_id,is_deleted,0',
            'account_id_num' => 'required|max:12|min:8|unique:customer_account,account_id_num,' . ',customer_account_id,is_deleted,0',
            'address'       => 'required|max:255',
            'province_id'  => 'required'
        ];
    }
    public function messages()
    {
        return [
            'account_name.required' => __('product::validation.child_account.enter_account_name'),
            'account_name.max' => __('product::validation.child_account.max_account_name'),

            'email.required' => __('product::validation.child_account.enter_account_mail'),
            'email.email' => __('product::validation.child_account.email_account_mail'),
            'email.unique' => __('product::validation.child_account.unique_account_mail'),

            'password.required' => __('product::validation.child_account.enter_account_password'),
            'password.max' => __('product::validation.child_account.max_account_password'),
            'password.min' => __('product::validation.child_account.min_account_password'),

            'account_id_num.required' => __('product::validation.child_account.enter_account_id_num'),
            'account_id_num.max' => __('product::validation.child_account.max_account_id_num'),
            'account_id_num.min' => __('product::validation.child_account.min_account_id_num'),
            'account_id_num.unique' => __('product::validation.child_account.unique_account_id_num'),

            'address.required' => __('product::validation.child_account.enter_address'),
            'address.max' => __('product::validation.child_account.max_address'),

            'province_id.required' =>  __('product::validation.child_account.enter_province'),

            'account_type.required' =>  __('product::validation.child_account.enter_account_type'),

            'account_phone.required' =>  __('product::validation.child_account.enter_account_phone'),
            'account_phone.max' =>  __('product::validation.child_account.max_account_phone'),
            'account_phone.min' =>  __('product::validation.child_account.min_account_phone'),
            'account_phone.unique' =>  __('product::validation.child_account.unique_account_phone'),

        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
