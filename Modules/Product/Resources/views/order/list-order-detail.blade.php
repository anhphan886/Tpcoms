<!--begin: Datatable -->

        <div class="kt-portlet__body nt_color_change">
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped table-responsive-sm text-center">
                        <thead class="thead-dark" >
                        <tr>
                            <th width="10%">
                                    STT
                            </th>
                            <th width="20%">
                                    Dịch vụ/Giải pháp
                            </th>
                            <th width="20%">
                                    Gói
                            </th>
                            <th width="10%">
                                @if(isset($arrOrderDetail[0]))
                                    @if($arrOrderDetail[0]['type'] == 'day')
                                        Thời gian (Ngày)
                                    @elseif($arrOrderDetail[0]['type'] == 'month')
                                        Thời gian (Tháng)
                                    @elseif($arrOrderDetail[0]['type'] == 'year')
                                        Thời gian (Năm)
                                    @else
                                        Thời gian (Tháng)
                                    @endif
                                @else
                                    Thời gian (Tháng)
                                @endif
                            </th>
                            <th width="10%">
                                   Tổng chi phí
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $money = 0;
                        ?>
                        @foreach($arrOrderDetail as $key => $item)
                            <tr>
                                <td >{{$key += 1 }}</td>
                                <td ><b>{{$item[getValueByLang('product_name_')]}}</b></td>
                                <td >
                                    @if(isset($arrAttribute[$item['order_detail_id']]))
                                        <div class="text-left">
                                            @foreach($arrAttribute[$item['order_detail_id']] as $itemAttribute)
                                                <div class="kt-widget1__item">
                                                    <div class="kt-widget1__title">
                                                        @if(!$itemAttribute['value'])
                                                            <span class="kt-widget1__desc">@lang('product::order.detail.unlimited') {{$itemAttribute['product_attribute_name_'.getValueByLang('')]}}</span>
                                                        @else
                                                            <span class="kt-widget1__desc">{{$itemAttribute['value'].' '.$itemAttribute['product_attribute_name_'.getValueByLang('')]}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td>{{$item['order_quantity']}}</td>
                                <td>
                                    <span >
                                    <span >
                                        <?php
                                        $money += $item['order_amount'];
                                        ?>
                                        {{number_format($item['order_amount'])}} VNĐ
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-lg-5 col-md-8 offset-lg-7 offset-md-4 nt_bold_total color-blue-table-fix">
                <table class="table">
                    <tbody>
                    <tr>
                        <td><strong><span>@lang('product::order.detail.price_without_taxes')</span></strong></td>
                        <td class="text-right kt-padding-r-50-desktop"><span>{{number_format($orderSelect['total'])}} VNĐ</span></td>
                    </tr>
                    <tr>
                        <td><strong><span>@lang('product::order.detail.discount')</span></strong></td>
                        <td class="text-right kt-padding-r-50-desktop"><span>{{number_format($orderSelect['discount'])}} VNĐ</span></td>
                    </tr>
                    <tr>
                        <td><strong><span>@lang('product::order.detail.tax')</span></strong></td>
                        <td class="text-right kt-padding-r-50-desktop"><span>{{number_format($orderSelect['vat'])}} VNĐ</span></td>
                    </tr>
                    <tr>
                        <td><strong ><span class="p-fontsize-20">@lang('product::order.detail.total')</span></strong></td>
                        <td class="text-right kt-padding-r-50-desktop"><strong><span class="p-fontsize-20">{{number_format($orderSelect['amount'])}} VNĐ</span></strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>
{{--            <div class="row">--}}
{{--                <div class="col-12 text-center">--}}
{{--                    <a href="{{route('product.order')}}">--}}
{{--                        <button type="button" class="btn btn-primary btn-hover-brand"><i class="fa fa-undo" aria-hidden="true"></i> @lang('product::order.detail.back')</button>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
