<?php

namespace Modules\Core\Http\Requests\AdminAction;

use Illuminate\Foundation\Http\FormRequest;

class AdminActionUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $action_id = $this->input('action_id');
        return [
            'action_name' => 'required|max:100|unique:admin_action,action_name,'.$action_id.',action_id,is_deleted,0',
        ];
    }

    public function messages()
    {
        return [
            'action_name.required' => __('core::validation.admin_action.action_name_required'),
            'action_name.max' => __('core::validation.admin_action.action_name_max'),
            'action_name.unique' => __('core::validation.admin_action.action_name_unique')
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
