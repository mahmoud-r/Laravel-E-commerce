@extends('admin.master')

@section('style')
    <style>

    </style>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('attributes.index')}}">Attribute Groups</a></li>
    <li class="breadcrumb-item active">list</li>
@endsection
@section('title')Attribute Groups @endsection

@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Attribute Groups</h1>
                </div>
                <div class="col-sm-6 text-right">
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
                        <th>Attributes</th>
                        <th style="display: none">created at</th>
                    </tr>
                    </thead>

                </table>
                <div id="example1_wrapper"></div>
            </div>
        </div>
    </div>

@endsection







@section('script')

    <script>
        $(document).ready(function() {
            var hCols = [];
            var table = $('#myTable').DataTable({
                rowReorder: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: '{{route('attributes.getAllCategories')}}',
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
                dom: '<"top"Qlf>rt<"bottom"ip><"clear">',
                columns: [
                    { data: null, render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'name', render: function(data, type, row) {
                            var imageUrl = row.image ? '{{ asset('uploads/category/images/thumb/') }}/' + row.image : '{{ asset('front_assets/images/empty-img.png') }}';
                            var editUrl = '{{ route("attributes.edit", ":id") }}'.replace(':id', row.id);
                            return '<a href="' + editUrl + '" class="d-flex gap-2 align-items-center">' +
                                '<img src="' + imageUrl + '" class="rounded" width="38" loading="lazy">' + data + '</a>';
                        }
                    },
                    { data: null, render: function(data, type, row) {
                            var attributeUrl = '{{ route("attributes.create", ":id") }}'.replace(':id', row.id);
                            return '<a href="' + attributeUrl + '" class="btn btn-primary">Attributes</a>';
                        }
                    },
                    { data: 'created_at' ,visible: false,render: function(data) {
                            return moment(data, 'YYYY-MM-DD').format('YYYY-MM-DD');
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
                }],
                searchBuilder: {
                    columns: [0,1,3],
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

    </script>

@endsection
