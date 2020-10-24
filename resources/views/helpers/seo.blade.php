@if (isset($dataSEO))
    @php $locale = \App::getLocale(); @endphp
    <meta name="description" content="{{ $dataSEO['description'] }}">
    <meta name="keywords" content="{{ $dataSEO['keywords'] }}">
    <title>TPCLOUD | {{ $dataSEO['title'] }}</title>

    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ route(getValueByLang('frontend.home_')) }}"/>
    <meta property="og:url" content="" />
    <meta property="og:locale" content="{{ $locale == 'vi' ? 'vi_VN' : 'en_US' }}" />
    <meta property="og:title" content="{{ $dataSEO['title'] }}" />
    <meta property="og:description" content="{{ $dataSEO['description'] }}" />
    <meta property="og:image" content="{{ asset($dataSEO['image']) }}" />
@else
    <meta name="description" content="TPcloud là dịch vụ cloud, máy chủ ảo sử dụng hạ tầng công nghệ VMware và thuộc sở hữu của TPcoms - Công ty Cổ Phần Công Nghệ Tiên Phát, nhà cung cấp các dịch vụ viễn thông và CNTT thành lập năm 2012, với hạ tầng viễn thông rộng khắp lãnh thổ Việt Nam...">
    <meta name="keywords" content="tpcloud,TpCloud">
    <title>TPCLOUD</title>

    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ route(getValueByLang('frontend.home_')) }}"/>
    <meta property="og:url" content="" />
    <meta property="og:locale" content="{{ $locale == 'vi' ? 'vi_VN' : 'en_US' }}" />
    <meta property="og:title" content="TPCLOUD" />
    <meta property="og:description" content="TPcloud là dịch vụ cloud, máy chủ ảo sử dụng hạ tầng công nghệ VMware và thuộc sở hữu của TPcoms - Công ty Cổ Phần Công Nghệ Tiên Phát, nhà cung cấp các dịch vụ viễn thông và CNTT thành lập năm 2012, với hạ tầng viễn thông rộng khắp lãnh thổ Việt Nam..." />
    <meta property="og:image" content="{{ asset('static/frontend/img/aboutus/img-1.jpg') }}" />
@endif
