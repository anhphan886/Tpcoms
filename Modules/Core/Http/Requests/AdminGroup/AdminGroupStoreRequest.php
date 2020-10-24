<?php

namespace Modules\Core\Http\Requests\AdminGroup;

use Illuminate\Foundation\Http\FormRequest;

class AdminGroupStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'group_name' => 'required|max:100|unique:admin_group,group_name,NULL,group_id,is_deleted,0'
        ];
    }

    public function messages()
    {
        return [
            'group_name.required' => __('core::validation.admin_group.group_name_required'),
            'group_name.max' => __('core::validation.admin_group.group_name_max'),
            'group_name.unique' => __('core::validation.admin_group.group_name_unique')
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
