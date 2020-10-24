<html>
<header></header>
<body>
<div style="width:  100%;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
<table style="font-family:'Arial';font-weight:400;font-style:normal;">
    <tbody>
    <tr>
        <td colspan="2"><h3 style="color : red;font-weight: bold; width: 100%; text-align:center;">YÊU CẦU HỖ TRỢ</h3>
            <p style="font-style: italic;">Dear Anh/Chị<br/>TPCLOUD đã nhận được thông tin yêu cầu hỗ trợ từ Anh/Chị</p>
        </td>
    </tr>
    <tr>
        <td style="height : 20px"></td>
    </tr>
    <tr>
        <th style="text-align:  left;font-weight: bold!important;">Trạng thái hổ trợ</th>
        <td style="line-height: 150%;">{{$data['ticket_status_name']}}</td>
    </tr>
    <tr>
        <th style="text-align:  left;font-weight: bold!important;">Dịch vụ</th>
        <td style="line-height: 150%;">{{$data['product_name_vi']}}</td>
    </tr>
    <tr>
        <th style="text-align:  left;font-weight: bold!important;">Yêu cầu</th>
        <td style="line-height: 150%;">{{$data['issue_name_vi']}}</td>
    </tr>
    <tr>
        <th style="text-align:  left;font-weight: bold!important;">Tiêu đề</th>
        <td style="line-height: 150%;">{{strip_tags($data['ticket_title'])}}</td>
    </tr>
    <tr>
        <th style="text-align:  left;font-weight: bold!important;">Ghi chú</th>
        <td style="line-height: 150%;">{{strip_tags($data['description']?? 'Không có miêu tả')}}</td>
    </tr>
    <tr>
        <th style="text-align:  left;font-weight: bold!important;">Thời gian tạo ticket</th>
        <td style="line-height: 150%;">{{isset($data['date_created'])?\Carbon\Carbon::parse($data['date_created'])->format('d/m/Y H:i:s'):''}}</td>
    </tr>
    <tr>
        <th style="text-align:  left;font-weight: bold!important;">Thời gian dự kiến hoàn thành</th>
        <td style="line-height: 150%;">{{isset($data['date_estimated'])?\Carbon\Carbon::parse($data['date_estimated'])->format('d/m/Y H:i:s'):''}}</td>
    </tr>
    @if($data['comment'] !== false)
    <tr>
        <th style="text-align:  left;font-weight: bold!important;">Bình luận mới của nhân viên: </th>
        <td style="line-height: 150%;">
            <textarea>
                {{strip_tags($data['comment']['comment_content'])}}
            </textarea>
        </td>
    </tr>
    @endif
    <tr>
        <tr>
            <td colspan="2" style="height: 70px; font-style: italic">
                TPCloud sẽ tiến liên hệ và xử lý trong thời gian sớm nhất .
                <br>Mọi thắc mắc Anh/ Chị có thể liên hệ tới hotline 1900800 để được giải đáp
            </td>
        </tr>
        <td colspan="2" style="height: 30px">
        <hr>
        </td>
    </tr>
    <tr>
        <td style="line-height: 150%;" rowspan="4">
            <img src="{{$host}}/static/backend/images/logo.png">
        </td>
            <td style="line-height: 150%;"><b style="text-align:  left;font-weight: bold!important;">Địa chỉ: </b>4 Nguyễn Đình Chiểu , Quận 1, TP.HCM</td>
        </tr>
        <tr>
            <td style="line-height: 150%;"><b style="text-align:  left;font-weight: bold!important;">Hotline KD:</b> +84 96803 6868</td>
        </tr>
        <tr>
            <td style="line-height: 150%;"><b style="text-align:  left;font-weight: bold!important;">Hotline KT:</b> +84 90281 8828</td>
        </tr>
        <tr>
            <td style="line-height: 150%;"><b style="text-align:  left;font-weight: bold!important;">Email:</b> tpcloud@tpcoms.vn</td>
        </tr>
</tbody>
</table></td>
</tr>
</table>
