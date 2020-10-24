@if (isset($listComment))
    @foreach ($listComment as $item)
        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{ $item['object_name'] }} <small>{{ date('d/m/Y H:i:s', strtotime($item['created_at'])) }}</small>
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body kh-mg-l" >
                {!! $item['comment_content'] !!}
                @if (isset($item['files']) && count($item['files']) > 0)
                    <div class="row">
                        @foreach ($item['files'] as $file)
                            <div class="col-12">
                                <a href="{{ $file['link_file'] }}" target="_blank" download class="min_content_a">{{ $file['file_name'] }}</a><br>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endforeach
@endif
@if (Route::currentRouteName() == 'ticket.edit')
    <form action="" method="POST" id="frm-comment">
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">
                        @lang('ticket::ticket.index.comment_content')
                    </label>
                    <div class="col-lg-9">
                        <div class="input-group">
                            <textarea name="comment_content" id="comment_content" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="form-text"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">@lang('ticket::ticket.index.comment_file')</label>
                    <div class="col-lg-8 col-md-9 col-sm-12">
                        <div class="kt-dropzone dropzone m-dropzone--primary dropzone-custome" id="uploadFileTicket">
                            <div class="kt-dropzone__msg dz-message needsclick">
                                <h3 class="kt-dropzone__msg-title">@lang('ticket::ticket.info.dropzone')</h3>
                                <span class="kt-dropzone__msg-desc">Hổ trợ các files word, excel, hình ảnh dưới 1MB</span><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-form-label col-lg-3 col-sm-12"></div>
                    <div class="col-lg-8 col-md-9 col-sm-12 text-center">
                    <button type="button" class="btn btn-primary" onclick="objTicket.postComment()">
                        @lang('ticket::ticket.input.button_send')
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif
