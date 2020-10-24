<div class="kt-content  kt-grid__item kt-grid__item--fluid nt_content" id="kt_content">
    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    @lang('product::contract.index.annex'):
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-12">
                    <div class="table_responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th id="th_group_name">
                                    <p class="pn-pointer">
                                        @lang('product::contract.index.stt')
                                    </p>
                                </th>
                                <th id="th_group_name">
                                    <p class="pn-pointer">
                                        @lang('product::contract.index.annex_no')
                                    </p>
                                </th>
                                <th id="th_group_name">
                                    <p class="pn-pointer">
                                        @lang('product::contract.index.customer')
                                    </p>
                                </th>
                                <th id="th_group_name">
                                    <p class="pn-pointer">
                                        @lang('product::contract.index.annex_date')
                                    </p>
                                </th>
                                <th id="th_group_name">
                                    <p class="pn-pointer">
                                        @lang('product::contract.index.contract_annex_sample')
                                    </p>
                                </th>
                                <th id="th_group_name">
                                    <p class="pn-pointer">
                                        @lang('product::contract.index.annex_file')
                                    </p>
                                </th>
                                <th id="th_group_name">
                                    <p class="pn-pointer">
                                        @lang('product::contract.index.upload_file_annex')
                                    </p>
                                </th>

{{--                                <th id="th_group_name">--}}
{{--                                    <p class="pn-pointer">--}}
{{--                                        @lang('product::contract.index.action')--}}
{{--                                    </p>--}}
{{--                                </th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($annex['list']))
                                @foreach($annex['list'] as $key => $value)
                                    <tr>
                                        <td>
                                            {{$key + 1}}
                                        </td>
                                        <td>
                                            {{$value['contract_annex_no']}}
                                        </td>
                                        <td>
                                            {{$value['customer_name']}}
                                        </td>
                                        <td>
                                            @if($value['contract_annex_date'] != '' && $value['contract_annex_date'] != '0000-00-00 00:00:00')
                                                {{(new DateTime($value['contract_annex_date']))->format('d/m/Y')}}
                                            @endif
                                        </td>
                                        <td>
                                            @foreach($allFileAnnex as $item)
                                                @if($item['file_type'] == 'contract_annex_sample' && $item['customer_contract_annex_id'] == $value['customer_contract_annex_id'])
                                                    <a href="{{BASE_URL_API.($item['link_file'])}}" title="{{$item['file_name']}}" target="_blank">
                                                        {{ subString($item['file_name'], 25) }}<br>
                                                    </a>
                                                @endif
                                            @endforeach

                                        </td>
                                        <td>
                                            @foreach($allFileAnnex as $item)
                                                @if($item['file_type'] == 'contract_annex_customer_sign' && $item['customer_contract_annex_id'] == $value['customer_contract_annex_id'])
                                                    <a href="{{BASE_URL_API.($item['link_file'])}}" title="{{$item['file_name']}}" target="_blank">
                                                        {{ subString($item['file_name'], 25) }}<br>
                                                    </a>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <label class="btn btn-sm btn-secondary">
                                                Upload
                                                <input accept="application/pdf"
                                                       onchange="contract.annexUpload('{{$value['customer_contract_annex_id']}}', this)" type="file"
                                                       style="display: none" value="{{1}}">
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
