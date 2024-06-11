@extends('admin.master')

@section('style')
    <style>
        div.dataTables_wrapper div.dataTables_filter {
            padding: 10px 10px 0 10px;
        }
        div.dataTables_wrapper div.dataTables_info,div.dataTables_wrapper div.dataTables_paginate{
            padding: 10px;
        }
        .dataTables_length {
            padding-right: 10px;
        }
        .dt-btn{
            background-color: #fff !important;
            border-color: #dce1e7!important;
            border-radius: .25rem!important;
            display: inline-block!important;
            background-image: none !important;
        }
        .dt-btn .icon {
            --bb-icon-size: 1.25rem;
            stroke-width: 1.5;
            font-size: var(--bb-icon-size);
            vertical-align: bottom;
            height: var(--bb-icon-size);
            width: var(--bb-icon-size);
        }
        .dt-down-arrow{
            --bb-icon-size: 0.5rem;
            stroke-width: 1.5;
            font-size: var(--bb-icon-size);
            vertical-align: bottom;
            height: var(--bb-icon-size);
            margin: 0 calc(1rem / 2) 0 calc(1rem / -4);
            width: var(--bb-icon-size);
            padding-left: 5px;

        }
        .dt-buttons{
            display: flex;
        }
        .dt-button-background{
            background: transparent !important;
        }
        .card-header{
            border-bottom: 0;
        }
        .dataTables_wrapper .bottom{
            display: flex;
            justify-content: space-between;
        }
        #card-tools .input-group{
            justify-content: flex-end;
        }
    </style>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('categories.index')}}">Categories</a></li>
    <li class="breadcrumb-item active">list</li>
@endsection

@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Categories</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('categories.create')}}" class="btn btn-primary">New Category</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
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
                <table class="table table-hover text-nowrap" id="myTable" style="width:100%">
                    <thead>
                    <tr>
                        <th >#</th>
                        <th>Name</th>
                        <th >Slug</th>
                        <th>Status</th>
                        <th >Sub Categories</th>
                        <th >Action</th>
                        <th style="display: none">created_at</th>
                    </tr>
                    </thead>

                </table>
                <div id="example1_wrapper"></div>
            </div>
            <div class="card-footer clearfix">
                {{$categories->links()}}
            </div>
        </div>
    </div>

@endsection







@section('script')

<script>
    $(document).ready(function() {
        var currentDate = new Date();
        var day = ("0" + currentDate.getDate()).slice(-2);
        var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
        var year = currentDate.getFullYear();
        var formattedDate = day + '-' + month + '-' + year;

        var hCols = [];
        var title = 'Categories-' + formattedDate;

        var table = $('#myTable').DataTable({
            rowReorder: true,
            responsive: true,
            autoWidth: false,
            ajax: {
                url: '{{route('categories.getAll')}}',
                dataSrc: ''
            },

            dom: '<"top"QlfB>rt<"bottom"ip><"clear">',
            columns: [
                { data: null, render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                { data: 'name', render: function(data, type, row) {
                        var imageUrl = row.image ? '{{ asset('uploads/category/images/thumb/') }}/' + row.image : '{{ asset('front_assets/images/empty-img.png') }}';
                        var editUrl = '{{ route("categories.edit", ":id") }}'.replace(':id', row.id);
                        return '<a href="' + editUrl + '" class="d-flex gap-2 align-items-center">' +
                            '<img src="' + imageUrl + '" class="rounded" width="38" loading="lazy">' + data + '</a>';
                    }
                },
                { data: 'slug' },
                { data: 'status', render: function(data) {
                        return data == 1 ? '<span class="badge bg-success text-success-fg">Published</span>' : '<span class="badge bg-secondary text-secondary-fg">Draft</span>';
                    }
                },
                { data: null, render: function(data, type, row) {
                        var subCategoryUrl = '{{ route("sub_category.index", ":id") }}'.replace(':id', row.id);
                        return '<a href="' + subCategoryUrl + '" class="btn btn-primary">Sub Categories</a>';
                    }
                },
                { data: null, render: function(data, type, row) {
                        var editUrl = '{{ route("categories.edit", ":id") }}'.replace(':id', row.id);
                        return '<a href="' + editUrl + '"><svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg></a>' +
                            '<a href="#" onclick="CategoryDelete(' + row.id + ',\'' + row.name + '\')" class="text-danger w-4 h-4 mr-1"><svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg></a>';
                    }
                },
                { data: 'created_at' ,visible: false,render: function(data) {
                        return moment(data, 'YYYY-MM-DD').format('DD/MM/YY');
                    }},
            ],

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
                        columns: [0, 1, 2, 3],
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
                        columns: [0, 1, 2, 3],
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
                        columns: [0, 1, 2, 3],
                        modifier: {
                            page: 'current'
                        }
                    },
                }, {
                    text: 'PDF Portrait',
                    extend: 'pdfHtml5',
                    className: 'btn dt-btn',
                    title: title,
                    message: '',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        modifier: {
                            page: 'current'
                        }
                    },
                }, {
                    text: 'PDF Landscape',
                    extend: 'pdfHtml5',
                    className: 'btn dt-btn',
                    title: title,
                    message: '',
                    orientation: 'landscape',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        modifier: {
                            page: 'current'
                        }
                    },
                }]
            }],
            searchBuilder: {
                columns: [0,1,2,3,6],
                preDefined: {
                    criteria: [
                        {
                            condition: 'contains',
                            value: 'Published'
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

        // Close filter card when clicking outside
        // $(document).on('click', function(event) {
        //     if (!$(event.target).closest('#filter-card, #filter-btn').length) {
        //         $('#filter-card').fadeOut();
        //     }
        // });

    });

    {{--$(document).ready(function() {--}}
    {{--    var currentDate = new Date();--}}
    {{--    var day = ("0" + currentDate.getDate()).slice(-2);--}}
    {{--    var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);--}}
    {{--    var year = currentDate.getFullYear();--}}
    {{--    var formattedDate = day + '-' + month + '-' + year;--}}

    {{--    var hCols = [];--}}
    {{--    var title = 'Categories-'+ formattedDate;--}}

    {{--    var table = $('#myTable').DataTable({--}}
    {{--        rowReorder: true,--}}
    {{--        responsive: true,--}}
    {{--        autoWidth: false,--}}
    {{--        ajax: {--}}
    {{--            url: '{{route('categories.getAll')}}',--}}
    {{--            dataSrc: ''--}}
    {{--        },--}}
    {{--        language: {--}}
    {{--            searchBuilder: {--}}
    {{--                button: 'Filter'--}}
    {{--            }--}}
    {{--        },--}}
    {{--        dom: '<"top"QlfB>rt<"bottom"ip><"clear">',--}}
    {{--        columns: [--}}
    {{--            { data: null, render: function (data, type, row, meta) {--}}
    {{--                    return meta.row + 1;--}}
    {{--                }},--}}
    {{--            { data: 'name', render: function(data, type, row) {--}}
    {{--                    var imageUrl = row.image ? '{{ asset('uploads/category/images/thumb/') }}/' + row.image : '{{ asset('front_assets/images/empty-img.png') }}';--}}
    {{--                    var editUrl = '{{ route("categories.edit", ":id") }}'.replace(':id', row.id);--}}
    {{--                    return '<a href="' + editUrl + '" class="d-flex gap-2 align-items-center">' +--}}
    {{--                        '<img src="' + imageUrl + '" class="rounded" width="38" loading="lazy">' + data + '</a>';--}}
    {{--                }},--}}
    {{--            { data: 'slug' },--}}
    {{--            { data: 'status', render: function(data) {--}}
    {{--                    return data == 1 ? '<span class="badge bg-success text-success-fg">Published</span>' : '<span class="badge bg-secondary text-secondary-fg">Draft</span>';--}}
    {{--                }},--}}
    {{--            { data: null, render: function(data, type, row) {--}}
    {{--                    var subCategoryUrl = '{{ route("sub_category.index", ":id") }}'.replace(':id', row.id);--}}
    {{--                    return '<a href="' + subCategoryUrl + '" class="btn btn-primary">Sub Categories</a>';--}}
    {{--                }},--}}
    {{--            { data: null, render: function(data, type, row) {--}}
    {{--                    var editUrl = '{{ route("categories.edit", ":id") }}'.replace(':id', row.id);--}}
    {{--                    return '<a href="' + editUrl + '"><svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg></a>' +--}}
    {{--                        '<a href="#" onclick="CategoryDelete(' + row.id + ',\'' + row.name + '\')" class="text-danger w-4 h-4 mr-1"><svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg></a>';--}}
    {{--                }},--}}


    {{--        ],--}}
    {{--        buttons: [{--}}
    {{--            extend: 'colvis',--}}
    {{--            className: 'btn dt-btn',--}}
    {{--            collectionLayout: 'one-column',--}}
    {{--            text: function() {--}}
    {{--                var totCols = $('#myTable thead th').length;--}}
    {{--                var hiddenCols = hCols.length;--}}
    {{--                var shownCols = totCols - hiddenCols;--}}
    {{--                return 'Columns (' + shownCols + ' of ' + totCols + ')';--}}
    {{--            },--}}
    {{--            prefixButtons: [{--}}
    {{--                extend: 'colvisGroup',--}}
    {{--                text: 'Show all',--}}
    {{--                show: ':hidden',--}}
    {{--                className: 'btn dt-btn',--}}
    {{--            }, {--}}
    {{--                extend: 'colvisRestore',--}}
    {{--                text: 'Restore',--}}
    {{--                className: 'btn dt-btn',--}}
    {{--            }]--}}
    {{--        }, {--}}
    {{--            extend: 'collection',--}}
    {{--            text: `<span>--}}
    {{--                              <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">--}}
    {{--                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>--}}
    {{--                              <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>--}}
    {{--                              <path d="M7 11l5 5l5 -5"></path>--}}
    {{--                              <path d="M12 4l0 12"></path>--}}
    {{--                            </svg> Export--}}
    {{--                    </span> `,--}}
    {{--            className: 'btn dt-btn',--}}
    {{--            buttons: [{--}}
    {{--                text: 'Excel',--}}
    {{--                extend: 'excelHtml5',--}}
    {{--                className: 'btn dt-btn',--}}
    {{--                title:title,--}}
    {{--                footer: false,--}}
    {{--                exportOptions: {--}}
    {{--                    columns: [0, 1, 2, 3],--}}
    {{--                    modifier: {--}}
    {{--                        page: 'current'--}}
    {{--                    }--}}
    {{--                },--}}

    {{--            }, {--}}
    {{--                text: 'CSV',--}}
    {{--                extend: 'csvHtml5',--}}
    {{--                className: 'btn dt-btn',--}}
    {{--                title:title,--}}
    {{--                fieldSeparator: ';',--}}
    {{--                exportOptions: {--}}
    {{--                    columns: [0, 1, 2, 3],--}}
    {{--                    modifier: {--}}
    {{--                        page: 'current'--}}
    {{--                    }--}}
    {{--                },--}}
    {{--            },{--}}
    {{--                text: 'Print',--}}
    {{--                extend: 'print',--}}
    {{--                className: 'btn dt-btn',--}}
    {{--                title:title,--}}
    {{--                exportOptions: {--}}
    {{--                    columns: [0, 1, 2, 3],--}}
    {{--                    modifier: {--}}
    {{--                        page: 'current'--}}
    {{--                    }--}}
    {{--                },--}}
    {{--            },{--}}
    {{--                text: 'PDF Portrait',--}}
    {{--                extend: 'pdfHtml5',--}}
    {{--                className: 'btn dt-btn',--}}
    {{--                title:title,--}}
    {{--                message: '',--}}
    {{--                exportOptions: {--}}
    {{--                    columns: [0, 1, 2, 3],--}}
    {{--                    modifier: {--}}
    {{--                        page: 'current'--}}
    {{--                    }--}}
    {{--                },--}}
    {{--            }, {--}}
    {{--                text: 'PDF Landscape',--}}
    {{--                extend: 'pdfHtml5',--}}
    {{--                className: 'btn dt-btn',--}}
    {{--                title:title,--}}
    {{--                message: '',--}}
    {{--                orientation: 'landscape',--}}
    {{--                exportOptions: {--}}
    {{--                    columns: [0, 1, 2, 3],--}}
    {{--                    modifier: {--}}
    {{--                        page: 'current'--}}
    {{--                    }--}}
    {{--                },--}}
    {{--            },],--}}
    {{--            searchBuilder: {--}}
    {{--                preDefined: {--}}
    {{--                    criteria: [--}}
    {{--                        {--}}
    {{--                            condition: 'contains',--}}
    {{--                            value: 'Published'--}}
    {{--                        }--}}
    {{--                    ]--}}
    {{--                },--}}
    {{--                columns: [--}}
    {{--                    {--}}
    {{--                        name: 'status',--}}
    {{--                        options: ['Published', 'Draft']--}}
    {{--                    },--}}
    {{--                    {--}}
    {{--                        name: 'created_at',--}}
    {{--                        type: 'date'--}}
    {{--                    }--}}
    {{--                ]--}}
    {{--            }--}}
    {{--        }],--}}
    {{--    });--}}

    {{--    table.buttons().container().appendTo('#card-tools .input-group');--}}

    {{--    $('.dataTables_length').appendTo('#card-title');--}}

    {{--    $('.dataTables_filter').appendTo('#card-title');--}}
    {{--    $('#myTable_length label').contents().filter(function() {--}}
    {{--        return this.nodeType === Node.TEXT_NODE;--}}
    {{--    }).remove();--}}

    {{--    $('.dataTables_filter label').contents().filter(function() {--}}
    {{--        return this.nodeType === Node.TEXT_NODE;--}}
    {{--    }).remove();--}}
    {{--    $('.dataTables_filter input').attr('placeholder', 'Search...');--}}
    {{--    $('.dataTables_filter').addClass('input-group').contents().unwrap();--}}


    {{--    // Initialize SearchBuilder--}}
    {{--    table.searchBuilder.container().prependTo('#card-title');--}}

    {{--});--}}



</script>

@endsection
