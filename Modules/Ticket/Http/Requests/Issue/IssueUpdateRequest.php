<?php

namespace Modules\Ticket\Http\Requests\Issue;

use Illuminate\Foundation\Http\FormRequest;

class IssueUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'portal_ticket_issue_level_id' => 'required',
            'process_time' => 'required|regex:/^\d+$/',
            'crictical_time2' => 'regex:/^\d+$/',
            'crictical_time3' => 'regex:/^\d+$/',
            'crictical_time4' => 'regex:/^\d+$/',
            'queue_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'portal_ticket_issue_level_id.required' => __('ticket::validation.issue.portal_ticket_issue_level_id_required'),
            'process_time.required' => __('ticket::validation.issue.process_time_required'),
            'queue_id.required' => __('ticket::validation.issue.queue_id_required'),
            'process_time.regex' => __('ticket::validation.issue.process_time_regex'),
            'crictical_time2.regex' => __('ticket::validation.issue.crictical_time2_regex'),
            'crictical_time3.regex' => __('ticket::validation.issue.crictical_time3_regex'),
            'crictical_time4.regex' => __('ticket::validation.issue.crictical_time4_regex'),
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
