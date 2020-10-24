<?php

namespace Modules\Ticket\Http\Requests\IssueGroup;

use Illuminate\Foundation\Http\FormRequest;

class IssueGroupStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'issue_group_name_vi' => 'required|max:255|unique:ticket_issue_group,issue_group_name_vi,NULL' . ',portal_ticket_issue_group_id,is_deleted,0',
            'issue_group_name_en' => 'required|max:255|unique:ticket_issue_group,issue_group_name_en,NULL' . ',portal_ticket_issue_group_id,is_deleted,0',
            'queue_id'            => 'required'
        ];
    }

    public function messages()
    {
        return [
            'issue_group_name_vi.required' => __('ticket::validation.issue_group.issue_group_name_vi_required'),
            'issue_group_name_en.required' => __('ticket::validation.issue_group.issue_group_name_en_required'),
            'issue_group_name_vi.unique' => __('ticket::validation.issue_group.issue_group_name_vi_unique'),
            'issue_group_name_en.unique' => __('ticket::validation.issue_group.issue_group_name_en_unique'),
            'queue_id.required' => __('ticket::validation.issue_group.queue_id_required'),
            'issue_group_name_vi.max' => __('ticket::validation.issue_group.issue_group_name_vi_max'),
            'issue_group_name_en.max' => __('ticket::validation.issue_group.issue_group_name_en_max')

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
