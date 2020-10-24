<?php

namespace Modules\Product\Http\Requests\segment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSegment extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->input('id');
        return [
            'name_vi' => 'required|max:255|unique:segment,name,'.$id.',id,is_deleted,0',
            'name_en' => 'required|max:255|unique:segment,name_en,'.$id.',id,is_deleted,0',
        ];
    }

    public function messages()
    {
        return [
            'name_vi.required' => __('product::validation.segment.enter_name_vi'),
            'name_vi.max' => __('product::validation.segment.max_name'),
            'name_vi.unique' => __('product::validation.segment.unique_name'),
            'name_en.required' => __('product::validation.segment.enter_name_en'),
            'name_en.max' => __('product::validation.segment.max_name_en'),
            'name_en.unique' => __('product::validation.segment.unique_name_en'),

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
