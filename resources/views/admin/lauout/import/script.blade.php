<!-- jQuery -->
<script src="{{asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin-assets/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('admin-assets/js/demo.js')}}"></script>
<!--dropzone -->
<script src="{{asset('admin-assets\plugins\dropzone\min\dropzone.min.js')}}"></script>
<!--select2 -->
<script src="{{asset('admin-assets\plugins\select2\js\select2.js')}}"></script>
<!--summernote -->
<script src="{{asset('admin-assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!--datepicker-->
<script src="{{asset('admin-assets/js/flatpickr.js')}}"></script>
<!--Chart.js-->
<script src="{{asset('admin-assets/plugins/chart.js/Chart.js')}}"></script>
<!--dataTables-->
<script src="{{asset('admin-assets/datatabljs/datatabl.js')}}"></script>


<script>
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    })
    $(function () {
        // Summernote
        $('.summernote').summernote({
            height: '300px'
        });
    });
</script>
@yield('script')

