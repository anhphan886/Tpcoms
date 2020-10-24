<?php

namespace Modules\Product\Http\Requests\attribute;

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
            'product_attribute_name_vi' => 'required|max:255|unique:product_attribute,product_attribute_name_vi,NULL,product_attribute_id',
            'product_attribute_name_en' => 'required|max:255|unique:product_attribute,product_attribute_name_en,NULL,product_attribute_id',
            'product_attribute_group_id' => 'required',
            'unit_name' => 'required',
            'price_month' => 'required',
            'price_day' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'product_attribute_group_id.required' => __('product::validation.attribute.enter_category'),
            'product_attribute_name_vi.required' => __('product::validation.attribute.enter_name_vi'),
            'product_attribute_name_en.required' => __('product::validation.attribute.enter_name_en'),
            'unit_name.required' => __('product::validation.attribute.enter_unit'),
            'product_attribute_name_vi.max' => __('product::validation.product.maxlength'),
            'product_attribute_name_en.max' => __('product::validation.product.maxlength'),
            'product_attribute_name_vi.unique' => __('product::validation.attribute.name_unique_vi'),
            'product_attribute_name_en.unique' => __('product::validation.attribute.name_unique_en'),
            'price_month.required' => __('product::validation.attribute.enter_price_month'),
            'price_day.required' => __('product::validation.attribute.enter_price_day'),
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
