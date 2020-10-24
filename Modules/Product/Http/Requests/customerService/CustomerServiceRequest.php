<?php

namespace Modules\Product\Http\Requests\customerService;

use Illuminate\Foundation\Http\FormRequest;

class CustomerServiceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'service_content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'service_content.required' => __('product::validation.service.'),
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
