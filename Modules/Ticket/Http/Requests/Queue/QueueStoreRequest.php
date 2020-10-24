<?php

namespace Modules\Ticket\Http\Requests\Queue;

use Illuminate\Foundation\Http\FormRequest;

class QueueStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'queue_name' => 'required|max:255|unique:ticket_queue,queue_name,'.',ticket_queue_id,is_deleted,0',
            'email_address' => 'required|email|max:100',
            'description' => 'max:255',
            'email_password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'queue_name.unique' => __('ticket::validation.queue.queue_name_unique'),
            'queue_name.max' => __('ticket::validation.queue.queue_name_max'),
            'queue_name.required' => __('ticket::validation.queue.queue_name_required'),
            'email_address.required' => __('ticket::validation.queue.email_address_required'),
            'email_password.required' => __('ticket::validation.queue.email_password_required'),
            'email_address.email' => __('ticket::validation.queue.email_address_email'),
            'email_address.max' => __('ticket::validation.queue.email_address_max'),
            'description.max' => __('ticket::validation.queue.des_max')
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
