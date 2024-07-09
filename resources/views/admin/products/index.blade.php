@extends('admin.master')


@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('products.index')}}">Products</a></li>
    <li class="breadcrumb-item active">list</li>
@endsection
@section('title')Products @endsection

@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products</h1>
                </div>
                @can('product-create')
                <div class="col-sm-6 text-right">
                    <a href="{{Route('products.create')}}" class="btn btn-primary">New Product</a>
                </div>
                @endcan
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
                <table class="table table-hover text-nowrap" id="myTable" style="width: 100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th></th>
                        <th>Product</th>
                        <th>category</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>

@endsection







@section('script')

<script>

    @can('product-delete')
    //Delete product
    function ProductDelete(id,name) {
        Swal.fire({
            title: "Do you want to Delete "+name+"?",
            showCancelButton: true,
            confirmButtonText: "Delete",
            confirmButtonColor: "#dc3545",
        }).then((result) => {
            if (result.isConfirmed) {
                var url = '{{Route("products.destroy","ID")}}';
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
                            $('#product_' + id).remove();
                        } if (response.status === false){
                            Toast.fire({
                                icon: 'error',
                                title: response.msg
                            });
                        }
                    }

                });
            }
        });
    }
    @endcan

    //product Table
    $(document).ready(function() {
        var currentDate = new Date();
        var day = ("0" + currentDate.getDate()).slice(-2);
        var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
        var year = currentDate.getFullYear();
        var formattedDate = day + '-' + month + '-' + year;

        var hCols = [];
        var title = 'Products-' + formattedDate;

        var table = $('#myTable').DataTable({
            rowReorder: true,
            responsive: true,
            autoWidth: false,
            ajax: {
                url: '{{route('products.getAll')}}',
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
                { data: null, title: '#', render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }},
                { data: 'images', title: 'Image', render: function(data, type, row) {
                        var image = data && data.length ?
                            '<img src="{{asset("uploads/products/images/thumb")}}/' + data[0].image + '" class="img-thumbnail" width="50">' :
                            '<img src="{{asset("admin-assets/img/default-150x150.png")}}" class="img-thumbnail" width="50">';
                        return image;
                    }},
                { data: 'title', title: 'Title', render: function(data, type, row) {
                        var productUrl = '{{route('products.edit',':id')}}'.replace(':id',row.id);
                        return '<a style="white-space: normal;" href="'+productUrl+'">' + data + '</a>';
                    }},
                { data: 'category.name', title: 'category' },
                { data: 'price', title: 'Price', render: function(data, type, row) {
                        return  data + ' EGP';
                    }},
                { data: 'qty', title: 'Quantity', render: function(data, type, row) {
                        return data ;
                    }},
                { data: 'status', title: 'Status', render: function(data, type, row) {
                        return data == 1 ?
                            '<span class="badge bg-success text-success-fg">Published</span>' :
                            '<span class="badge bg-secondary text-secondary-fg">Draft</span>';
                    }},
                { data: null, title: 'Actions', render: function(data, type, row) {
                        var productUrl = '{{ route("products.edit", ":id") }}'.replace(':id', row.id);
                        return ' <a href="'+productUrl +'">'+
                            '<svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">' +
                            '<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>' +
                            '</svg>' +
                            '</a> ' +
                            ' @can('product-delete')<a href="#" onclick="ProductDelete(' + row.id + ', \'' + row.title + '\')" class="text-danger w-4 h-4 mr-1">' +
                            '<svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">' +
                            '<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>' +
                            '</svg>' +
                            '</a>@endcan';
                    }}
            ],
            rowCallback: function(row, data) {
                $(row).attr('id', 'product_' + data.id);
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
                        columns: [0,2,3,4,5,6],
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
                        columns: [0,2,3,4,5,6],
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
                        columns: [0,2,3,4,5,6],
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
                        columns: [0,2,3,4,5,6],
                        modifier: {
                            page: 'current'
                        }
                    },
                },]
            }],
            searchBuilder: {
                columns: [0,2,3,4,5,6],
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
</script>
@endsection
