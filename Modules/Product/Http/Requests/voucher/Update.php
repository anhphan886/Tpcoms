<?php

namespace Modules\Product\Http\Requests\voucher;

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
            'code' => 'required|max:25|unique:vouchers,code,'.$id.',voucher_id,is_deleted,0',
//            'cash_percent' => 'required',
//            'cash' => 'required',
//            'percent' => 'required',
            'quota' => 'max:11',
            'expired_date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => __('product::validation.voucher.enter_code'),
            'code.max' => __('product::validation.voucher.max_code'),
            'code.unique' => __('product::validation.voucher.unique_code'),

            'cash_percent.required' => __('product::validation.voucher.enter_cash_percent'),
            'cash.required' => __('product::validation.voucher.enter_cash'),
            'percent.required' => __('product::validation.voucher.enter_percent'),

            'quota.max' => __('product::validation.voucher.max_quota'),

            'expired_date.required' => __('product::validation.voucher.enter_expire_date'),
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
