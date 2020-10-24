<?php

namespace Modules\Product\Http\Requests\productCategory;

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
            'category_name_vi' => 'required|max:255|unique:product_categories,category_name_vi,NULL,product_category_id',
            'category_name_en' => 'required|max:255|unique:product_categories,category_name_en,NULL,product_category_id',
        ];
    }

    public function messages()
    {
        return [
            'category_name_vi.required' => __('product::validation.product_category.enter_name_vi'),
            'category_name_en.required' => __('product::validation.product_category.enter_name_en'),
            'category_name_vi.max' => __('product::validation.product.maxlength'),
            'category_name_en.max' => __('product::validation.product.maxlength'),
            'category_name_vi.unique' => __('product::validation.product_category.name_unique_vi'),
            'category_name_en.unique' => __('product::validation.product_category.name_unique_en'),
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
