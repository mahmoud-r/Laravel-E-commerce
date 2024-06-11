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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/searchbuilder/1.1.0/js/dataTables.searchBuilder.min.js"></script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/searchbuilder/1.7.1/js/searchBuilder.bootstrap4.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/datetime/1.1.0/js/dataTables.dateTime.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://momentjs.com/downloads/moment.min.js"></script>


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

