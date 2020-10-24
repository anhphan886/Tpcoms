<html>
<header></header>

<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <div style="width:  100%;">
                    <img src="{{$host}}/static/backend/images/logo.png">
                    <h3 style="color : red; width: 100%; text-align:center;">THÔNG TIN HỖ TRỢ</h3>
                    <p style="font-style: italic;text-align:center">Dear Anh/Chị Dưới đây là thông tin cần hỗ trợ</p>
                    <div style="align-content: center;">
                        <table style="font-family:'Arial';font-weight:400;font-style:normal;">
                            <tbody>
                                <tr>
                                    <th style="text-align:  left; font-weight: bold;">Mã ticket:</th>
                                    <td style="line-height: 150%;"><a target="_blank"
                                            href="{{route('ticket.show', ['id' => $data['ticket_id']])}}">{{$data['ticket_code']}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align:  left; font-weight: bold;">Khách hàng :</th>
                                    <td style="line-height: 150%;"><a target="_blank"
                                            href="{{route('product.customer.detail', ['id' => $data['customer_id']])}}">{{$data['customer_no']}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align:  left; font-weight: bold;">Dịch vụ :</th>
                                    <td style="line-height: 150%;">{{$data['product_name_vi']}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align:  left; font-weight: bold;">Yêu cầu :</th>
                                    <td style="line-height: 150%;">{{$data['issue_name_vi']}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align:  left; font-weight: bold;">Tiêu đề :</th>
                                    <td style="line-height: 150%;">{{strip_tags($data['ticket_title'])}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align:  left; font-weight: bold;">Ghi chú:</th>
                                    <td style="line-height: 150%;">
                                        {{strip_tags($data['description']?? 'Không có miêu tả')}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align:  left; font-weight: bold;">Thời gian tạo ticket:</th>
                                    <td style="line-height: 150%;">
                                        {{isset($data['date_created'])?\Carbon\Carbon::parse($data['date_created'])->format('d/m/Y H:i:s'):''}}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align:  left; font-weight: bold;">Thời gian quy định hoàn thành:
                                    </th>
                                    <td style="line-height: 150%;">
                                        {{isset($data['date_expected'])?\Carbon\Carbon::parse($data['date_expected'])->format('d/m/Y H:i:s'):''}}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align:  left; font-weight: bold;">Thời gian dự kiến hoàn thành:</th>
                                    <td style="line-height: 150%;">
                                        @if(isset($data['date_estimated']) && $data['date_estimated'] == null)
                                            {{\Carbon\Carbon::parse($data['date_expected'])->format('d/m/Y H:i:s')}}
                                        @else
                                            {{\Carbon\Carbon::parse($data['date_estimated'])->format('d/m/Y H:i:s')}}
                                        @endif
{{--                                        {{isset($data['date_estimated'])?\Carbon\Carbon::parse($data['date_estimated'])->format('d/m/Y H:i:s'):'Chưa có'}}--}}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align:  left; font-weight: bold;">Cấp Độ:</th>
                                    <td style="line-height: 150%;">{{$data['issue_level_value']}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align:  left; font-weight: bold;">Mức Quan Trọng:</th>
                                    <td style="line-height: 150%;">{{$data['crictical_level']}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align:  left; font-weight: bold;">Tình trạng xử lý:</th>
                                    <td style="line-height: 150%;">{{$data['ticket_status_name']}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align:  left; font-weight: bold;">Queue xử lý :</th>
                                    <td style="line-height: 150%;">{{$data['queue_name']}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align:  left; font-weight: bold;">Đã chỉ định nhân viên xử lý:</th>
                                    <td style="line-height: 150%;">
                                        @forelse ($data['processors'] as $user)
                                        {{$user['full_name']}},
                                        @empty
                                        Chưa có người
                                        @endforelse
                                    </td>
                                </tr>
                                @if($data['comment'] !== false)
                                <tr>
                                    <th style="text-align:  left; font-weight: bold;">Bình luận mới của người dùng:
                                    </th>
                                    <td style="line-height: 150%;">
                                        <textarea>
                                            {{isset($data['comment']['comment_content'])?strip_tags($data['comment']['comment_content']): ''}}
                                        </textarea>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                <tr>
                                    <td style="height: 30px">
                                </tr>
                                <td colspan="2">
                                    <p> Yêu cầu các Bộ phận và Cá nhân liên quan vui lòng kiểm tra xử lý.<br>* Nhân Viên
                                        Tạo Ticket : {{$data['ticket_creator'] ?? 'Không có tên'}} ( ID:
                                        {{$data['created_by'] ?? 'Không'}} ) - Bộ Phận :
                                        {{isset($creator_queue)? $creator_queue: 'Không có'}}</p>
                                </td>
        </tr>
        <tr>
            <td style="height: 60px" align="center" colspan="2">
                <a target="_blank" href="{{route('ticket.show', ['id' => $data['ticket_id']])}}"
                    style="border-radius: 5px; padding : 10px; background-color: white; height: 20px; width : 100px; border:1px solid orange; text-decoration: none; color : orange; transition: 0.3s; align-self: center;">Đến
                    trang hổ trợ</a>
            </td>
        </tr>

        </tbody>
        </div>
    </table>
    </div>
    </div>
    </td>
    </tr>
    </table>
