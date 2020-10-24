<?php

namespace Modules\Product\Http\Requests\productTemplate;

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
            'parent_id' => 'required',
            'price_month' => 'required',
            'price_day' => 'required',
            'product_name_vi' => 'required|max:255|unique:product,product_name_vi,' . ',product_id,is_deleted,0,is_template,1',
            'product_name_en' => 'required|max:255|unique:product,product_name_en,' . ',product_id,is_deleted,0,is_template,1',
        ];
    }

    public function messages()
    {
        return [
            'parent_id.required' => __('product::validation.product_template.enter_parent_id'),
            'product_name_vi.required' => __('product::validation.product_template.enter_product_name_vi'),
            'product_name_en.required' => __('product::validation.product_template.enter_product_name_en'),
            'price_month.required' => __('product::validation.product_template.enter_price_month'),
            'price_day.required' => __('product::validation.product_template.enter_price_day'),
            'product_name_vi.unique' => __('product::validation.product_template.name_unique_vi'),
            'product_name_en.unique' => __('product::validation.product_template.name_unique_en'),
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
