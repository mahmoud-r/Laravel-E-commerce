<!DOCTYPE html>
<html lang="en">

@include('admin.lauout.import.head')

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    @include('admin.lauout.nav')
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    @include('admin.lauout.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @yield('header')

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@include('admin.lauout.footer')

</div>
@include('admin.lauout.import.message')

<!-- ./wrapper -->
@include('admin.lauout.import.script')

</body>
</html>
