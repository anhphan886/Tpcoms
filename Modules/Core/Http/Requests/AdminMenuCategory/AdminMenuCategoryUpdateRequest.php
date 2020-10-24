<?php

namespace Modules\Core\Http\Requests\AdminMenuCategory;

use Illuminate\Foundation\Http\FormRequest;

class AdminMenuCategoryUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $adminMenuCategoryId = $this->input('menu_category_id');

        return [
            'menu_category_name' => 'required|max:250|unique:admin_menu_category,menu_category_name,'.
                $adminMenuCategoryId.',menu_category_id,is_actived,1',
            'menu_category_position' => 'required|integer|max:1000000|numeric|unique:admin_menu_category,menu_category_position,'.
                $adminMenuCategoryId.',menu_category_id,is_actived,1',
        ];
    }

    public function messages()
    {
        return [
            'menu_category_name.required' => __('core::validation.admin_menu_category.menu_category_name_required'),
            'menu_category_name.max' => __('core::validation.admin_menu_category.menu_category_name_max'),
            'menu_category_name.unique' => __('core::validation.admin_menu_category.menu_category_name_unique'),
            'menu_category_position.required' => __('core::validation.admin_menu_category.menu_category_position_required'),
            'menu_category_position.numeric' => __('core::validation.shared.numeric'),
            'menu_category_position.integer' => __('core::validation.shared.integer'),
            'menu_category_position.unique' => __('core::validation.admin_menu_category.menu_category_position_unique'),
            'menu_category_position.max' => __('core::validation.admin_menu_category.menu_category_position_max'),
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
