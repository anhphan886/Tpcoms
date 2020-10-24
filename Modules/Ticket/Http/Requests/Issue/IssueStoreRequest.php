<?php

namespace Modules\Ticket\Http\Requests\Issue;

use Illuminate\Foundation\Http\FormRequest;

class IssueStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $portal_ticket_issue_group_id = $this->input('portal_ticket_issue_group_id');
        return [
            'issue_name_vi' => 'required|max:250|unique:ticket_issue,issue_name_vi,null,portal_ticket_issue_id,portal_ticket_issue_group_id,'.$portal_ticket_issue_group_id.',is_deleted,0',
            'issue_name_en' => 'required|max:250|unique:ticket_issue,issue_name_en,null,portal_ticket_issue_id,portal_ticket_issue_group_id,'.$portal_ticket_issue_group_id.',is_deleted,0',
            'portal_ticket_issue_group_id' => 'required',
            'portal_ticket_issue_level_id' => 'required',
            'process_time' => 'required|regex:/^\d+$/',
            'crictical_time2' => 'required|regex:/^\d+$/',
            'crictical_time3' => 'required|regex:/^\d+$/',
            'crictical_time4' => 'required|regex:/^\d+$/',
            'queue_id' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'issue_name_vi.required' => __('ticket::validation.issue.issue_name_vi_required'),
            'issue_name_vi.max' => __('ticket::validation.issue.issue_name_vi_max'),
            'issue_name_en.max' => __('ticket::validation.issue.issue_name_en_max'),
            'issue_name_en.required' => __('ticket::validation.issue.issue_name_en_required'),
            'issue_name_vi.unique' => __('ticket::validation.issue.issue_name_vi_unique'),
            'issue_name_en.unique' => __('ticket::validation.issue.issue_name_en_unique'),
            'portal_ticket_issue_group_id.required' => __('ticket::validation.portal_ticket_issue_group_id_required'),
            'portal_ticket_issue_level_id.required' => __('ticket::validation.issue.portal_ticket_issue_level_id_required'),
            'process_time.required' => __('ticket::validation.issue.process_time_required'),
            'queue_id.required' => __('ticket::validation.issue.queue_id_required'),
            'process_time.regex' => __('ticket::validation.issue.process_time_regex'),
            'crictical_time2.regex' => __('ticket::validation.issue.crictical_time2_regex'),
            'crictical_time3.regex' => __('ticket::validation.issue.crictical_time3_regex'),
            'crictical_time4.regex' => __('ticket::validation.issue.crictical_time4_regex'),
            'crictical_time2.required' => __('ticket::validation.issue.crictical_time2_required'),
            'crictical_time3.required' => __('ticket::validation.issue.crictical_time3_required'),
            'crictical_time4.required' => __('ticket::validation.issue.crictical_time4_required'),
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
