<?php

namespace Modules\Product\Http\Requests\customer;

use http\Env\Request;
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
        $param = request()->all();
        $id = $param['id'];
        return [
            'customer_name' => 'required|max:255',
            'customer_id_num' => 'required|max:20|unique:customer,customer_id_num,'. $id .',customer_id,is_deleted,0',
            'customer_phone' => 'required|max:10|unique:customer,customer_phone,'. $id .',customer_id,is_deleted,0',
            'customer_phone2' => 'max:11',
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

            'customer_phone2.max' => __('product::validation.customer.max_phone'),

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
