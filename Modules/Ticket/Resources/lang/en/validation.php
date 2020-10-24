<?php

return [
    'ticket' => [
        'ticket_title_required' => 'Please enter a title',
        'issue_id_required' => 'Please select the issue',
        'issue_level_required' => 'Please select a level',
        'crictical_level_required' => 'Please select alert level',
        'date_issue_required' => 'Please enter a time when the problem  arise',
        'date_estimated_required' => 'Please enter your estimated time to complete',
        'customer_service_id_required' => 'Please select customer service',
        'customer_account_id_required' => 'Please select  client account',
        'queue_process_id_required' => 'Please select  queue',
        'platform_required' => 'Please enter the platform',
        'ticket_id_required' => 'Please pass the ticket id',
        'ticket_title_max' => 'Please enter a title of up to 100 characters',
        'date_estimated_wrong' => 'Estimated time for completion must be greater than the time for incident occurrence',
        'size_too_large' => 'File is too large',
        ],

    'queue' => [
        'queue_name_required' => 'Please enter queue name',
        'email_address_required' => 'Please enter email',
        'email_password_required' => 'Please enter password',

        'TITLE_POPUP' => 'Do you want to delete the queue ?',
        'TEXT_POPUP' => 'You will not be able to undo!',
        'HTML_POPUP' => 'When a queue is deleted, that queue cannot be restored.'.
            '<br>Are you sure want to deleted this queue?',
        'YES_BUTTON' => 'Agree to delete!',
        'CANCEL_BUTTON' => 'Do not delete',
    ],

    'issue' => [
        'issue_name_vi_required' => 'Please enter issue (Vietnamese)',
        'issue_name_en_required' => 'Please entet issue (English)',
        'issue_name_vi_unique' => 'Vietnamese issue name already exists',
        'issue_name_en_unique' => 'English issue name already exists',

        'portal_ticket_issue_group_id_required' => 'Please select issue group',
        'portal_ticket_issue_level_id_required' => 'please select level',
        'process_time_required' => 'Please enter process time',
        'crictical_time2_required' => 'Please enter crictical time 2',
        'crictical_time3_required' => 'Please enter crictical time 3',
        'crictical_time4_required' => 'Please enter crictical time 4',
        'queue_id_required' => 'Please select queue',
        'TITLE_POPUP' => 'Do you want to delete this issue ?',
        'TEXT_POPUP' => 'You will not be able to undo!',
        'HTML_POPUP' => 'When the issue is deleted, it will not be recoverable.'.
            '<br>Are you sure want to deleted this issue ?',
        'YES_BUTTON' => 'Agree to delete!',
        'CANCEL_BUTTON' => 'Do not delete',
    ],

    'issue_group' => [
        'issue_group_name_vi_required' => 'Please enter issue group name (Vietnamese)',
        'issue_group_name_en_required' => 'Please enter issue group name (English)',
        'issue_group_name_vi_unique' => 'Vietnamese issue group name already exists',
        'issue_group_name_en_unique' => 'English issue group name already exists',
        'TITLE_POPUP' => 'Do you want to delete this issue group ?',
        'TEXT_POPUP' => 'You will not be able to undo !',
        'HTML_POPUP' => 'When the issue group is deleted, it will not be recoverable.'.
            '<br>Are you sure want to deleted this issue group ?',
        'YES_BUTTON' => 'Agree to delete!',
        'CANCEL_BUTTON' => 'Do not delete',
    ],
];
