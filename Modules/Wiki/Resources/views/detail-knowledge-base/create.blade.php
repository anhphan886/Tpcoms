@extends('layout')
@section('title')
    @parent
    {{--    {{ $title }}--}}
@endsection
@section('header')
    @include('components.header',['title' => 'Config'])
@endsection
@section('content')
    <div class="kt-subheader kt-grid__item" id="kt_subheader">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">@lang('wiki::wiki.index.taoknowledgebase')</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <span class="kt-subheader__desc" id="kt_subheader_total"> </span>

            </div>
            <div class="kt-subheader__group kt-hidden" id="kt_subheader_group_actions">

            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <div class="btn-group">
                <button type="submit" class="btn btn-primary" onclick="knowledgebase.add(0)">
                    @lang('wiki::wiki.index.luuvathoat')
                </button>
                <button type="submit" class="btn btn-primary" onclick="knowledgebase.add(1)">
                    @lang('wiki::wiki.index.luuvataomoi')
                </button>
                <a class="btn btn-default btn-bold" href="{{route('wiki.knowledge-base')}}">
                    @lang('wiki::wiki.index.quaylaitrangtruoc')
                </a>
            </div>
        </div>
    </div>

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-padding-0" id="kt_content">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <label>@lang('wiki::wiki.index.danhmuc')</label>
                        </div>
                        <div class="col-10">
                            <select type="text" name="category_id" id="category_id" class="form-control --select2 ss--width-100">
                                @foreach($listCategory as $value)
                                    <option value="{{$value['id']}}">{{$value[getValueByLang('name_')]}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <label>@lang('wiki::wiki.index.tenen')</label>
                        </div>
                        <div class="col-10">
                            <input type="text" name="name_en" class="form-control" id="name_en">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <label>@lang('wiki::wiki.index.tenvi')</label>
                        </div>
                        <div class="col-10">
                            <input type="text" name="name_vi" class="form-control" id="name_vi">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <label>@lang('wiki::wiki.index.noidungen')</label>
                        </div>
                        <div class="col-10">
                            <div class="summernote">
                                <textarea class="form-control" name="description_en" id="description_en" ></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <label>@lang('wiki::wiki.index.noidungvi')</label>
                        </div>
                        <div class="col-10">
                            <div class="summernote">
                                <textarea class="form-control" name="description_vi" id="description_vi" ></textarea>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection
@section('after_script')
    <script>
        $('#description_en').summernote({
            height: 200,
            callbacks: {
                onImageUpload: function(files) {
                    for(let i=0; i < files.length; i++) {
                        $.uploadEn(files[i]);
                    }
                }
            },
        });

        $('#description_vi').summernote({
            // placeholder: 'Nhập nội dung',
            height: 200,
            callbacks: {
                onImageUpload: function(files) {
                    for(let i=0; i < files.length; i++) {
                        $.uploadVi(files[i]);
                    }
                }
            },
        });

    </script>
    <script type="text/javascript" src="{{ asset('static/backend/js/wiki/knowledge-base.js?v='.time()) }}"></script>
@endsection
