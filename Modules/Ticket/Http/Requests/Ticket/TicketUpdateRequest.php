<?php

namespace Modules\Ticket\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class TicketUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ticket_id' => 'required',
            'queue_process_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'ticket_id.required' => __('ticket::validate.ticket.ticket_id_required'),
            'queue_process_id.required' => __('ticket::validate.ticket.queue_process_id_required'),
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
