<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 12/12/2019
 * Time: 3:14 PM
 */

namespace Modules\Product\Http\Requests\receipt;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public function rules()
    {
        return [
            'receipt_by' => 'required',
            'payer' => 'required|max:255',
            'payment_type' => 'required',
            'amount' => 'required',
//            'image_avatar' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'receipt_by.required' => __('product::validation.receipt.enter_staff'),
            'payer.required' => __('product::validation.receipt.enter_payer'),
            'payer.max' => __('product::validation.product.maxlength'),
            'payment_type.required' => __('product::validation.receipt.enter_payment_type'),
            'amount.required' => __('product::validation.receipt.enter_amount_money'),
//            'image_avatar.required' => __('product::validation.receipt.image_avatar'),
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
