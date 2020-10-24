<?php

namespace Modules\Product\Http\Requests\customer;

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
        $param = request()->all();
//        dd($param);
        return [
            'customer_name' => 'required|max:255',
            'customer_id_num' => 'required|max:20|unique:customer,customer_id_num,'.',customer_id,is_deleted,0',
            'customer_phone' => 'required|max:10|unique:customer,customer_phone,'.',customer_id,is_deleted,0',
            'customer_email' => 'required|max:255|unique:customer,customer_email,'.',customer_id,is_deleted,0',
            'customer_phone2' => 'max:11',
            'account_password' => 'required|min:8|max:128'
        ];
    }

    public function messages()
    {
        return [
            'customer_name.required' => __('product::validation.customer.enter_customer_name'),
            'customer_name.max' => __('product::validation.customer.max_name'),

            'customer_id_num.required' => __('product::validation.customer.enter_customer_id_num'),
            'customer_id_num.max' => __('product::validation.customer.max_num'),
            'customer_id_num.unique' => __('product::validation.customer.customer_num_id_unique'),

            'customer_phone.required' => __('product::validation.customer.enter_customer_phone'),
            'customer_phone.max' => __('product::validation.customer.max_phone'),
            'customer_phone.unique' => __('product::validation.customer.customer_phone_unique'),

            'customer_email.required' => __('product::validation.customer.enter_customer_email'),
            'customer_email.max' => __('product::validation.customer.max_email'),
            'customer_email.unique' => __('product::validation.customer.customer_email_unique'),

            'customer_phone2.max' => __('product::validation.customer.max_phone'),

            'account_password.required' =>__('product::validation.customer.account_password_required'),
            'account_password.min' =>__('product::validation.customer.account_password_min_max'),
            'account_password.max' =>__('product::validation.customer.account_password_min_max'),
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
