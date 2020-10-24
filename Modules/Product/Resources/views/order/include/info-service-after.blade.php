<div class="table_responsive">
    <table class="table table-striped ss-unset-min-hight">
        <thead>
        <tr>
            <th>
                @lang('product::order.create_adjust.stt')
            </th>
            <th class="text-center">
                @lang('product::order.create_adjust.form')
            </th>
            <th class="text-center">
                @lang('product::order.create_adjust.service')
            </th>
            <th class="text-center">
                @lang('product::order.create_adjust.package')
            </th>
            <th class="text-center">
                @lang('product::order.create_adjust.attribute_change')
            </th>
            <th class="text-center">
                @lang('product::order.create_adjust.datetime')
            </th>
            <th class="text-center">
                @lang('product::order.create_adjust.cost')
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @php $amount = 0; @endphp
            <td>01</td>
            <td class="text-center">Cập nhật</td>
            <td class="text-center product_name_vi_table"></td>
            <td class="text-align-left">
                @foreach($attribute_result as $item)
                    {{$item['product_attribute_name_vi'] . ' ' }}
                    {{isset($item['new_value']) ? $item['new_value'] : $item['value']}}
                    {{ ' ' . $item['unit_name']}}
                    <br>
                    @php $amount += ((isset($item['new_value']) ? $item['new_value'] : $item['value']) * $item['price_month']); @endphp
                @endforeach
            </td>
            <td class="text-align-left">
                @foreach($attribute_new as $item)
                    {{$item['product_attribute_name_vi'] . ' ' . $item['new_value'] . ' ' . $item['unit_name']}}
                    <br>
                @endforeach
            </td>
            <td class="text-center">
                {{$service_detail['quantity']}}
            </td>
            <td class="text-align-right">
                {{number_format($service_detail['quantity'] * $amount, 0)}}
            </td>
        </tr>
        </tbody>
    </table>
</div>
<input type="hidden" id="total_hidden" value="{{$service_detail['quantity'] * $amount}}">
