<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Dashboard ::@yield('title')</title>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.7.1/css/searchBuilder.bootstrap4.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css">


    <!--custom -->
    <link rel="stylesheet" href="{{asset('admin-assets/css/custom.css')}}">



    @yield('style')
</head>
