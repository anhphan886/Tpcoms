<?php

namespace Modules\Product\Http\Requests\invoice;

use Illuminate\Foundation\Http\FormRequest;

class invoiceUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->input('invoice_id');
        $status = $this->input('status');
        if($status == 'new'){
            return [];
        }
        if($status == 'finish') {
            return [
                'invoice_by' => 'required',
                'status' => 'required',
                'invoice_number' => 'required|unique:invoice,invoice_number,'.$id.',invoice_id',
                'invoice_at' => 'required'
            ];
        } else {
            return [
//                'invoice_by' => 'required',
//                'status' => 'required',
            ];
        }
    }

    public function messages()
    {
        return [
            'invoice_at.required' => __('product::validation.invoice.invoice_at_required'),
            'invoice_by.required' => __('product::validation.invoice.invoice_by_required'),
            'status.required' => __('product::validation.invoice.status'),
            'invoice_number.required' => __('product::validation.invoice.invoice_number_required'),
            'invoice_number.unique' => __('product::validation.invoice.invoice_number_unique')
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
