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
                            @if(!isset($data['type']))
                                <h3 style="color : red;font-weight: bold; width: 100%; text-align:center;">
                                    THÔNG BÁO PHIẾU THU SẮP HẾT HẠN THANH TOÁN
                                </h3>
                                <p style="font-style: italic;">Dear Anh/Chị<br/>Phiếu thu sau đã sắp hết hạn thanh toán</p>
                            @else
                                <h3 style="color : red;font-weight: bold; width: 100%; text-align:center;">
                                    THÔNG BÁO THANH TOÁN PHIẾU THU THÀNH CÔNG
                                </h3>
                                <p style="font-style: italic;">Dear Anh/Chị<br/>Phiếu thu đã được thanh toán</p>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th style="text-align:  left;font-weight: bold!important;">Mã phiếu thu</th>
                        <td style="line-height: 150%;">{{$data['receipt_no']}}</td>
                    </tr>
                    <tr>
                        <th style="text-align:  left;font-weight: bold!important;">Hạn thanh toán</th>
                        <td style="line-height: 150%;">
                            {{\Carbon\Carbon::parse($data['pay_expired'])->format('d/m/Y')}}
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:  left;font-weight: bold!important;">Tổng tiền phải thanh toán</th>
                        <td style="line-height: 150%;">{{number_format($data['amount'] + $data['vat'], 0)}} VNĐ</td>
                    </tr>
                    @if(isset($data['pay_now']))
                        <tr>
                            <th style="text-align:  left;font-weight: bold!important;">Số tiền vừa thanh toán</th>
                            <td style="line-height: 150%;">
                                {{number_format($data['pay_now'], 0)}} VNĐ
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th style="text-align:  left;font-weight: bold!important;">Còn nợ</th>
                        <td style="line-height: 150%;">
                            @if(isset($data['debt']))
                                {{number_format($data['debt'], 0)}} VNĐ
                            @else
                                {{number_format($data['amount'] + $data['vat'], 0)}} VNĐ
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:  left;font-weight: bold!important;">Trạng thái phiếu thu</th>
                        <td style="line-height: 150%;">
                            @if($data['status'] == 'paid')
                                @lang('product::customer.receipt.paid')
                            @elseif($data['status'] == 'unpaid')
                                @lang('product::customer.receipt.unpaid')
                            @elseif($data['status'] == 'refund')
                                @lang('product::customer.receipt.refund')
                            @elseif($data['status'] == 'part-paid')
                                @lang('product::customer.receipt.part_paid')
                            @elseif($data['status'] == 'cancel')
                                @lang('product::customer.receipt.cancel')
                            @endif
                        </td>
                    </tr>
                    @if(isset($data['type']))
                        <tr>
                            <th style="text-align:  left;font-weight: bold!important;">Người thanh toán</th>
                            <td style="line-height: 150%;">{{$data['payer']}}</td>
                        </tr>
                        <tr>
                            <th style="text-align:  left;font-weight: bold!important;">Người thu</th>
                            <td style="line-height: 150%;">{{$data['receipt_by']}}</td>
                        </tr>
                    @endif
                    @if(isset($data['note']))
                        <tr>
                            <th style="text-align:  left;font-weight: bold!important;">Ghi chú</th>
                            <td style="line-height: 150%;">{{$data['note']}}</td>
                        </tr>
                    @endif
                    @if(isset($data['receipt_content']))
                        <tr>
                            <th style="text-align:  left;font-weight: bold!important;">Nội dung phiếu thu</th>
                            <td style="line-height: 150%;">{{$data['receipt_content']}}</td>
                        </tr>
                    @endif
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
