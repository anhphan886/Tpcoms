<?php

namespace Modules\Core\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required',
        ];
    }

    /*
     * function custom messages
     */
    public function messages()
    {
        return [
            'full_name.required' => __('core::validation.admin.PLEASE_ENTER_NAME'),
        ];
    }
}
