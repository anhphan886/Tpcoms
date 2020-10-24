<?php

return [
    'ticket' => [
        'ticket_issue_group_id_required' => 'Vui lòng chọn nhóm vấn đề',
//        'customer_account_id_required' => 'Vui lòng chọn khách hàng cần thông báo',
//        'customer_service_id_required' => 'Vui lòng chọn dịch vụ',
        'ticket_id_required' => 'Vui lòng truyền ticket id',
        'ticket_title_required' => 'Vui lòng nhập tiêu đề',
        'ticket_title_max' => 'Vui lòng nhập tiêu đề tối đa 100 ký tự',
        'issue_id_required' => 'Vui lòng chọn vấn đề',
        'issue_level_required' => 'Vui lòng chọn cấp độ',
        'crictical_level_required' => 'Vui lòng chọn cấp độ cảnh báo',
        'date_issue_required' => 'Vui lòng nhập thời gian phát sinh sự cố',
        'date_estimated_required' => 'Vui lòng nhập thời gian dự kiến hoàn tất',
        'customer_service_id_required' => 'Vui lòng chọn dịch vụ khách hàng',
        'customer_id_required' => 'Vui lòng chọn  khách hàng',
        'queue_process_id_required' => 'Vui lòng chọn queue',
        'platform_required' => 'Vui lòng nhập platform',
        'date_estimated_wrong' => 'Thời gian dự kiến hoàn tất phải lớn hơn thời gian phát sinh sự cố',
        'size_too_large' => 'File quá lớn',
        'add_success' => 'Email thông báo chi tiết ticket quá thời gian xử lý đã được gửi'
    ],
    'issue' => [
        'issue_name_vi_required' => 'Vui lòng nhập tên yêu cầu tiếng Việt',
        'issue_name_en_required' => 'Vui lòng nhập tên yêu cầu tiếng Anh',
        'issue_name_vi_unique' => 'Tên yêu cầu tiếng Việt đã tồn tại',
        'issue_name_en_unique' => 'Tên yêu cầu tiếng Anh đã tồn tại',
        'issue_name_vi_max' => 'Tên yêu cầu  tiếng Việt không được nhập quá 255 ký tự',
        'issue_name_en_max' => 'Tên yêu cầu  tiếng Anh không được nhập quá 255 ký tự',

        'portal_ticket_issue_group_id_required' => 'Vui lòng chọn nhóm yêu cầu',
        'portal_ticket_issue_level_id_required' => 'Vui lòng chọn cấp độ',
        'process_time_required' => 'Vui lòng nhập thời gian xử lý quy định',
        'crictical_time2_required' => 'Vui lòng nhập thời gian xử lý mức 1',
        'crictical_time3_required' => 'Vui lòng nhập thời gian xử lý mức 2',
        'crictical_time4_required' => 'Vui lòng nhập thời gian xử lý mức 3',
        'process_time_regex' => 'Thời gian xử lý chỉ được nhập số và có giá trị lớn hơn 0',
        'crictical_time2_regex' => 'Thời gian xử lý mức 1 chỉ được nhập số và có giá trị lớn hơn 0',
        'crictical_time3_regex' => 'Thời gian xử lý mức 2 chỉ được nhập số và có giá trị lớn hơn 0',
        'crictical_time4_regex' => 'Thời gian xử lý mức 3 chỉ được nhập số và có giá trị lớn hơn 0',



        'queue_id_required' => 'Vui lòng chọn queue',
        'TITLE_POPUP' => 'Bạn có muốn xóa  yêu cầu này không?',
        'TEXT_POPUP' => 'Bạn sẽ không thể hoàn tác!',
        'HTML_POPUP' => 'Khi yêu cầu bị xóa, yêu cầu đó sẽ không thể khôi phục lại được.'.
            '<br>Bạn có chắc chắn muốn xóa  yêu cầu này không?',
        'YES_BUTTON' => 'Đồng ý xoá!',
        'CANCEL_BUTTON' => 'Không xóa',
    ],
    'issue_group' => [
        'issue_group_name_vi_required' => 'Vui lòng nhập tên nhóm yêu cầu tiếng Việt',
        'issue_group_name_en_required' => 'Vui lòng nhập tên nhóm yêu cầu tiếng Anh',
        'issue_group_name_vi_unique' => 'Tên nhóm yêu cầu tiếng Việt này đã tồn tại',
        'issue_group_name_en_unique' => 'Tên nhóm yêu cầu tiếng Anh này đã tồn tại',
        'issue_group_name_vi_max' => 'Tên nhóm tiếng Việt chỉ được tối đa 255 ký tự',
        'issue_group_name_en_max' => 'Tên nhóm tiếng Anh chỉ được tối đa 255 ký tự',
        'queue_id_required' => 'Vui lòng chọn queue xử lý yêu cầu',
        'TITLE_POPUP' => 'Bạn có muốn xóa nhóm yêu cầu không?',
        'TEXT_POPUP' => 'Bạn sẽ không thể hoàn tác!',
        'HTML_POPUP' => 'Khi nhóm yêu cầu bị xóa, nhóm  đó sẽ không thể khôi phục lại được.'.
            '<br>Bạn có chắc chắn muốn xóa nhóm  này không?',
        'YES_BUTTON' => 'Đồng ý xoá!',
        'CANCEL_BUTTON' => 'Không xóa',
    ],
    'queue' => [
        'queue_name_unique' => 'Tên Queue đã tồn tại, vui lòng chọn tên khác',
        'queue_name_max' => 'Tên Queue không được quá 255 ký tự',
        'queue_name_required' => 'Vui lòng nhập tên queue',
        'email_address_required' => 'Vui lòng nhập email',
        'email_password_required' => 'Vui lòng nhập mật khẩu',
        'email_address_email' => 'Vui lòng nhập đúng định dạng email',
        'email_address_max' => 'Email quá dài(Tối đa 100 ký tự)',
        'TITLE_POPUP' => 'Bạn có muốn xóa queue  không?',
        'TEXT_POPUP' => 'Bạn sẽ không thể hoàn tác!',
        'HTML_POPUP' => 'Khi queue  bị xóa, queue đó sẽ không thể khôi phục lại được.'.
            '<br>Bạn có chắc chắn muốn xóa queue  này không?',
        'YES_BUTTON' => 'Đồng ý xoá!',
        'CANCEL_BUTTON' => 'Không xóa',
        'des_max' => 'Mô tả không được quá 255 ký tự'
    ]
];
