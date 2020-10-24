<?php

namespace Modules\Core\Http\Requests\AdminMenu;

use Illuminate\Foundation\Http\FormRequest;

class AdminMenuStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $menuCategoryId = $this->input('menu_category_id');
        return [
            'menu_name' => 'required|unique:admin_menu,menu_name,'.
                'NULL,menu_id,menu_category_id,'.$menuCategoryId.',is_actived,1',
            'menu_position' => 'required|integer|max:1000000|numeric|unique:admin_menu,menu_position,'.
                'NULL,menu_id,menu_category_id,'.$menuCategoryId.',is_actived,1',
        ];
    }

    public function messages()
    {
        return [
            'menu_name.required' => __('core::validation.admin_menu.menu_name_required'),
            'menu_name.unique' => __('core::validation.admin_menu.menu_name_unique'),
            'menu_position.required' => __('core::validation.admin_menu.menu_position_required'),
            'menu_position.numeric' => __('core::validation.shared.numeric'),
            'menu_position.integer' => __('core::validation.shared.integer'),
            'menu_position.unique' => __('core::validation.admin_menu.menu_position_unique'),
            'menu_position.max' => __('core::validation.admin_menu.menu_position_max'),
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
