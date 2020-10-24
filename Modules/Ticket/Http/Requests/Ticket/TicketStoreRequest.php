<?php

namespace Modules\Ticket\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class TicketStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ticket_title' => 'required|max:100',
            'ticket_issue_group_id' => 'required',
	        'issue_id' => 'required',
	        'issue_level' => 'required',
//            'date_issue' => 'required',
//            'date_estimated' => 'required',
            'queue_process_id' => 'required',
            'customer_id' => 'required',
//            'customer_service_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'ticket_title.required' => __('ticket::validate.ticket.ticket_title_required'),
            'ticket_title.max' => __('ticket::validate.ticket.ticket_title_max'),
            'issue_id.required' => __('ticket::validate.ticket.issue_id_required'),
            'issue_level.required' => __('ticket::validate.ticket.issue_level_required'),
            'date_issue.required' => __('ticket::validate.ticket.date_issue_required'),
            'date_estimated.required' => __('ticket::validate.ticket.date_estimated_required'),
            'queue_process_id.required' => __('ticket::validate.ticket.queue_process_id_required'),
            'ticket_issue_group_id.required' => __('ticket::validate.ticket.ticket_issue_group_id_required'),
            'customer_id.required' => __('ticket::validate.ticket.customer_id_required'),
            'customer_service_id.required' => __('ticket::validate.ticket.customer_service_id_required'),
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
