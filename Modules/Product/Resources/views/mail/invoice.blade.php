<html>
<header></header>
<body>
<div style="width:  100%;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <table style="font-family:'Arial';font-weight:400;font-style:normal; width: 50%">
                    <tbody>
                    <tr>
                        <td colspan="2">
                            <h3 style="color : red;font-weight: bold; width: 100%; text-align:center;">
                                THÔNG TIN HÓA ĐƠN
                            </h3>
                            <p style="font-style: italic;">Dear Anh/Chị<br/>Thông tin hóa đơn đã được tạo</p>
                        </td>
                    </tr>

                    <tr>
                        <th style="text-align:  left;font-weight: bold!important;">Mã hóa đơn</th>
                        <td style="line-height: 150%;">{{$data['invoice_no']}}</td>
                    </tr>
                    <tr>
                        <th style="text-align:  left;font-weight: bold!important;">Khách hàng</th>
                        <td style="line-height: 150%;">{{$data['customer_name']}}</td>
                    </tr>
                    <tr>
                        <th style="text-align:  left;font-weight: bold!important;">Tổng tiền chưa thuế</th>
                        <td style="line-height: 150%;">{{number_format($data['amount'] - $data['vat'], 0)}} VNĐ</td>
                    </tr>
                    <tr>
                        <th style="text-align:  left;font-weight: bold!important;">Thuế</th>
                        <td style="line-height: 150%;">{{number_format($data['vat'], 0)}} VNĐ</td>
                    </tr>
                    <tr>
                        <th style="text-align:  left;font-weight: bold!important;">Tổng tiền phải trả</th>
                        <td style="line-height: 150%;">{{number_format($data['amount'], 0)}} VNĐ</td>
                    </tr>
                    <tr>
                        <th style="text-align:  left;font-weight: bold!important;">Trạng thái hóa đơn</th>
                        <td style="line-height: 150%;">
                            @if($data['status'] == 'new')
                                @lang('product::customer.service.new')
                            @elseif($data['status'] == 'finish')
                                @lang('product::customer.service.finish')
                            @elseif($data['status'] == 'cancel')
                                @lang('product::customer.service.cancel')
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="height: 30px">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <td style="line-height: 150%;" rowspan="4">
                            <img src="{{$data['host']}}/static/backend/images/logo.png">
                        </td>
                        <td style="line-height: 150%;"><b style="text-align:  left;font-weight: bold!important;">Địa
                                chỉ: </b>4 Nguyễn Đình Chiểu , Quận 1, TP.HCM
                        </td>
                    </tr>
                    <tr>
                        <td style="line-height: 150%;"><b style="text-align:  left;font-weight: bold!important;">Hotline
                                KD:</b> +84 96803 6868
                        </td>
                    </tr>
                    <tr>
                        <td style="line-height: 150%;"><b style="text-align:  left;font-weight: bold!important;">Hotline
                                KT:</b> +84 90281 8828
                        </td>
                    </tr>
                    <tr>
                        <td style="line-height: 150%;">
                            <b style="text-align:  left;font-weight: bold!important;">Email:</b> tpcloud@tpcoms.vn
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
