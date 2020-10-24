<?php

namespace Modules\Product\Http\Requests\product;

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
        $id = $this->input('product_id');
        return [
            'product_category_id' => 'required',
            'product_name_vi' => 'required|max:255|unique:product,product_name_vi,' .$id. ',product_id,is_deleted,0,is_template,0',
            'product_name_en' => 'required|max:255|unique:product,product_name_vi,' .$id. ',product_id,is_deleted,0,is_template,0',
        ];
    }

    public function messages()
    {
        return [
            'product_category_id.required' => __('product::validation.product.enter_product_category'),
            'product_name_vi.required' => __('product::validation.product.enter_product_name_vi'),
            'product_name_vi.max' => __('product::validation.product.maxlength'),
            'product_name_vi.unique' => __('product::validation.product.product_unique_vi'),
            'product_name_en.required' => __('product::validation.product.enter_product_name_en'),
            'product_name_en.max' => __('product::validation.product.maxlength'),
            'product_name_en.unique' => __('product::validation.product.product_unique_en'),
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
