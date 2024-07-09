@extends('admin.master')


@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('newsletter.index')}}">Newsletter</a></li>
    <li class="breadcrumb-item active">list</li>
@endsection

@section('title')Newsletter @endsection

@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><a style="color: black" href="{{route('newsletter.index')}}">Newsletter</a></h1>
                </div>
                @can('newsletter-create')
                <div class="col-sm-6 text-right">
                    <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#create-email">New Email</a>
                </div>
                @endcan
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

@section('style')
    <style>

    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card mb-3 table-configuration-wrap" id="filter-card" style="display: none " >
            <div class="card-body" id="searchBuilder" >

            </div>
        </div>

        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-title d-flex justify-content-end align-items-center" id="card-title">

                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                        <div class="card-tools" id="card-tools">
                            <div class="input-group input-group" style="width: 250px;">

                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="myTable" style="width: 100%;">
                    <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Email</th>
                        <th>Date</th>
                        @can('newsletter-delete')
                            <th>Delete</th>
                        @endcan
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@can('newsletter-create')

    @include('admin.newsletter.create')

@endcan

@endsection







@section('script')

<script>
    @can('newsletter-delete')
      function EmailDelete(id,name) {
        Swal.fire({
            title: "Do you want to Delete "+name+" review ?",
            showCancelButton: true,
            confirmButtonText: "Delete",
            confirmButtonColor: "#dc3545",
        }).then((result) => {
            if (result.isConfirmed) {
                var url = '{{Route("newsletter.destroy","ID")}}';
                var newUrl =url.replace('ID',id)
                $.ajax({
                    url: newUrl,
                    type: 'DELETE',
                    data: '',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    },success: function (response) {

                        if(response['status'] === true){
                            Swal.fire("Deleted!", "", "success");
                            $('#email_' + id).remove();
                        }else {
                            console.log('something went wrong')
                        }
                    }

                });
            }
        });
    }
    @endcan
    $(document).ready(function() {
        var currentDate = new Date();
        var day = ("0" + currentDate.getDate()).slice(-2);
        var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
        var year = currentDate.getFullYear();
        var formattedDate = day + '-' + month + '-' + year;

        var hCols = [];
        var title = 'newsletter-' + formattedDate;

        var table = $('#myTable').DataTable({
            rowReorder: true,
            responsive: true,
            autoWidth: false,
            ajax: {
                url: '{{route('newsletter.getAll')}}',
                dataSrc: ''
            },
            language: {
                searchBuilder: {
                    add: '+',
                    condition: 'Comparator',
                    clearAll: 'Reset',
                    delete: 'Delete',
                    deleteTitle: 'Delete Title',
                    data: 'Column',
                    left: 'Left',
                    leftTitle: 'Left Title',
                    logicAnd: 'AND',
                    logicOr: 'Or',
                    right: 'Right',
                    rightTitle: 'Right Title',
                    title: {
                        0: 'Filters',
                        _: 'Filters (%d)'
                    },
                    value: 'Option',
                    valueJoiner: 'et'
                }
            },
            dom: '<"top"QlfB>rt<"bottom"ip><"clear">',
            columns: [
                { data: null, render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                { data: 'email', name: 'email' },
                { data: 'created_at', name: 'date' ,render: function(data) {
                        return moment(data, 'YYYY-MM-DD').format('YYYY-MM-DD');
                    }},
                {
                    data: 'delete',
                    name: 'delete',
                    render: function(data, type, row) {
                        return '  @can('newsletter-delete')<a href="#" onclick="EmailDelete(' + row.id + ', \'' + row.email + '\', this)" class="text-danger w-4 h-4 mr-1">' +
                            '<svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">' +
                            '<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>' +
                            '</svg>' +
                            '</a>@endcan';
                    }
                },
            ],
            rowCallback: function(row, data) {
                $(row).attr('id', 'email_' + data.id);
            },
            buttons: [{
                extend: 'collection',
                text: `<span>
                              <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                              <path d="M7 11l5 5l5 -5"></path>
                              <path d="M12 4l0 12"></path>
                            </svg> Export
                    </span> `,
                className: 'btn dt-btn',
                buttons: [{
                    text: 'Excel',
                    extend: 'excelHtml5',
                    className: 'btn dt-btn',
                    title: title,
                    footer: false,
                    exportOptions: {
                        columns: [0, 1, 2],
                        modifier: {
                            page: 'current'
                        }
                    },
                }, {
                    text: 'CSV',
                    extend: 'csvHtml5',
                    className: 'btn dt-btn',
                    title: title,
                    fieldSeparator: ';',
                    exportOptions: {
                        columns: [0, 1, 2],
                        modifier: {
                            page: 'current'
                        }
                    },
                }, {
                    text: 'Print',
                    extend: 'print',
                    className: 'btn dt-btn',
                    title: title,
                    exportOptions: {
                        columns: [0, 1, 2],
                        modifier: {
                            page: 'current'
                        }
                    },
                }, {
                    text: 'PDF',
                    extend: 'pdfHtml5',
                    className: 'btn dt-btn',
                    title: title,
                    message: '',
                    exportOptions: {
                        columns: [0, 1, 2],
                        modifier: {
                            page: 'current'
                        }
                    },
                },]
            }],
            searchBuilder: {
                columns: [0, 1, 2],
                preDefined: {
                    criteria: [
                        {
                            condition: 'contains',
                            value: 'Published',
                        },
                    ]
                },
            }
        });
        // Add filter button next to the search input
        $('#card-tools .input-group ').append('<button id="filter-btn" class="dt-button btn dt-btn ml-2">Filter</button>');

        table.buttons().container().appendTo('#card-tools .input-group');

        $('.dataTables_length').appendTo('#card-title');

        $('.dataTables_filter').appendTo('#card-title');
        $('#myTable_length label').contents().filter(function() {
            return this.nodeType === Node.TEXT_NODE;
        }).remove();

        $('.dataTables_filter label').contents().filter(function() {
            return this.nodeType === Node.TEXT_NODE;
        }).remove();
        $('.dataTables_filter input').attr('placeholder', 'Search...');

        $('.dataTables_filter').addClass('input-group').contents().unwrap();

        // Show filter card on button click
        $('#filter-btn').on('click', function() {
            $('#filter-card').fadeToggle();
        });

        // Initialize SearchBuilder
        table.searchBuilder.container().appendTo('#searchBuilder');

    });

    @can('newsletter-create')
     $('#NewsletterForm').submit(function (e){
        e.preventDefault();
        var form =$(this);
        $.ajax({
            url:'{{Route('newsletter.store')}}',
            type:'post',
            data:form.serializeArray(),
            dataType:'json',
            success:function (response){

                if(response.status == true){
                    $('.error').removeClass('invalid-feedback').html('');
                    $("input[type='text'],input[type='number'],select").removeClass('is-invalid')
                    window.location.href="{{route('newsletter.index')}}";
                }else {
                    handleErrors(response.errors);
                }
            },error:function (jqXHR,exception){
                console.log('something went wrong')
            }
        })
    });

     function handleErrors(errors) {
        $('.error').removeClass('invalid-feedback').html('');
        $("input[type='text'],input[type='number'],select").removeClass('is-invalid');

        $.each(errors, function (key, value) {
            $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(`${value}`);
        });}
    @endcan
</script>
@endsection
