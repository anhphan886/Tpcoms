<?php

namespace Modules\Product\Http\Requests\customerChildAccount;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->input('customer_account_id');
//        $pattern = 'regex:/^[0|\+84]\d{9,11}$/';
        return [
            'account_name' => 'required|max:255',
            'account_phone' => 'required|max:11|min:10|unique:customer_account,account_phone,' .$id. ',customer_account_id,is_deleted,0',
            'address'       => 'required|max:255',
        ];
    }
    public function messages()
    {
        return [
            'product_category_id.required' => __('product::validation.product.enter_product_category'),
            'account_name.required' => __('product::validation.child_account.enter_account_name'),
            'account_name.max' => __('product::validation.child_account.max_account_name'),
            'account_phone.required' => __('product::validation.child_account.enter_account_phone'),
            'account_phone.max' => __('product::validation.child_account.max_account_phone'),
            'account_phone.min' => __('product::validation.child_account.min_account_phone'),
            'account_phone.unique' => __('product::validation.child_account.unique_account_phone'),
            'account_phone.regex' => __('product::validation.child_account.regex_account_phone'),
            'address.required' => __('product::validation.child_account.enter_address'),
            'address.max' => __('product::validation.child_account.max_address'),

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
