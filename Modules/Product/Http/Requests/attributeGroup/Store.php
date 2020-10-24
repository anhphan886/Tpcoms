<?php

namespace Modules\Product\Http\Requests\attributeGroup;

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
            'product_attribute_group_name_vi' => 'required|max:255|unique:product_attribute_group,product_attribute_group_name_vi,NULL,product_attribute_group_id',
            'product_attribute_group_name_en' => 'required|max:255|unique:product_attribute_group,product_attribute_group_name_en,NULL,product_attribute_group_id',
            'positions' => 'required|unique:product_attribute_group,positions,NULL,product_attribute_group_id',
        ];
    }

    public function messages()
    {
        return [
            'product_attribute_group_name_vi.required' => __('product::validation.attribute-group.enter_name_vi'),
            'product_attribute_group_name_en.required' => __('product::validation.attribute-group.enter_name_en'),
            'product_attribute_group_name_vi.max' => __('product::validation.product.maxlength'),
            'product_attribute_group_name_en.max' => __('product::validation.product.maxlength'),
            'product_attribute_group_name_vi.unique' => __('product::validation.attribute_group.name_unique_vi'),
            'product_attribute_group_name_en.unique' => __('product::validation.attribute_group.name_unique_en'),
            'positions.required' => __('product::validation.attribute_group.enter_positions'),
            'positions.unique' => __('product::validation.attribute_group.positions_unique'),
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
