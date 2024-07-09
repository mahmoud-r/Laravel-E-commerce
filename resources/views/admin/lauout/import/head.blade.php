<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title','Dashboard') | {{config('settings.store_name')}}</title>

    @if(!empty(get_setting('favicon_icon')))
            <link rel="shortcut icon" type="image/x-icon" href="{{asset('uploads/site/images/'.get_setting('favicon_icon'))}}">
    @else
            <link rel="shortcut icon" type="image/x-icon" href="{{asset('/front_assets/images/favicon.png')}}">
    @endif
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin-assets/css/adminlte.min.css')}}">
    <!--dropzone -->
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/dropzone/min/dropzone.css')}}">
    <!--select2 -->
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/select2/css/select2.min.css')}}">
    <!--summernote-->
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/summernote/summernote-bs4.min.css')}}">
    <!--datepicker-->
    <link rel="stylesheet" href="{{asset('admin-assets/css/flatpickr.min.css')}}">
    <!--chartjs-->
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/chart.js/Chart.css')}}">
    <!--dataTables-->
    <link rel="stylesheet" href="{{asset('admin-assets/datatabljs/datatabl.css')}}">
    <!--custom -->
    <link rel="stylesheet" href="{{asset('admin-assets/css/custom.css')}}">



    @yield('style')
</head>
