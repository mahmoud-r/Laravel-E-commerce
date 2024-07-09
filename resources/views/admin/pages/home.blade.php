@extends('admin.master')


@section('style')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__rendered li{
            color:#000;
        }
        .card-header{
            border-bottom: 1px solid rgba(4,32,69,.1);
        }
    </style>
@endsection
@section('title')Pages - Home @endsection


@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('pages.index')}}">Pages</a></li>
    <li class="breadcrumb-item active">Home</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Home</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('pages.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <form name="HomeForm"  action="" id="HomeForm" method="post">
        <div class="container-fluid layout-navbar-fixed">
            <div class="row">
                <div class="col-md-9">

                    {{-- section 1--}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Categories Section</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="homeSections[section1][title]">Title</label>
                                        <input type="text" name="homeSections[section1][title]" id="homeSections[section1][title]" value="{{$homeSections['section1']['title']}}" class="form-control " placeholder="Title">
                                        <p class="error"></p>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="homeSections[section1][description]">Description</label>
                                        <textarea class="form-control textarea-auto-height" name="homeSections[section1][description]" id="homeSections[section1][description]"  placeholder="Add Description...">{{$homeSections['section1']['description']}}</textarea>
                                        <p class="error"></p>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- section 2--}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Flash sale Section</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="homeSections[section2][title]">Title</label>
                                        <input type="text" name="homeSections[section2][title]" id="homeSections[section2][title]" value="{{$homeSections['section2']['title']}}" class="form-control" placeholder="Title">
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- section 3--}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Section Three</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="homeSections[section3][title]">Title</label>
                                        <input type="text" name="homeSections[section3][title]" id="homeSections[section3][title]" value="{{$homeSections['section3']['title']}}" class="form-control" placeholder="Title">
                                        <p class="error"></p>
                                    </div>
                                    <table class="table table-vcenter card-table table-hover table-striped swatches-container text-center">
                                        <thead class="header">
                                        <tr>
                                            <th width="3%">#</th>
                                            <th width="30%">Title</th>
                                            <th>Source Type</th>
                                            <th>Source Value</th>
                                        </tr>
                                        </thead>

                                        <tbody class="ui-sortable" >

                                        @foreach($homeSections['section3']['subsections'] as $i => $section3)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>
                                                    <input type="text" name="homeSections[section3][subsections][{{ $i }}][title]" id="homeSections[section3][subsections][{{ $i }}][title]" value="{{ $homeSections['section3']['subsections'][$i]['title'] }}" class="form-control" placeholder="Title">
                                                </td>
                                                <td>
                                                    <select class="form-control" name="homeSections[section3][subsections][{{ $i }}][source_type]">
                                                        <option value="">Select Value</option>
                                                        <option value="category" {{ $homeSections['section3']['subsections'][$i]['source_type'] == 'category' ? 'selected' : '' }}>Category</option>
                                                        <option value="collection" {{ $homeSections['section3']['subsections'][$i]['source_type'] == 'collection' ? 'selected' : '' }}>Collection</option>
                                                        <option value="top_rated" {{ $homeSections['section3']['subsections'][$i]['source_type'] == 'top_rated' ? 'selected' : '' }}>Top Rated</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="homeSections[section3][subsections][{{ $i }}][source_id]" data-selected="{{ $homeSections['section3']['subsections'][$i]['source_id'] }}" >
                                                        <option value="">Select Value</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>


                      {{-- section 4--}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Section Four</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="homeSections[section4][title]">Title</label>
                                        <input type="text" name="homeSections[section4][title]" id="homeSections[section4][title]" value="{{$homeSections['section4']['title']}}" class="form-control" placeholder="Title">
                                        <p class="error"></p>
                                    </div>
                                    <table class="table table-vcenter card-table table-hover table-striped swatches-container text-center">
                                        <thead class="header">
                                        <tr>
                                            <th width="3%">#</th>
                                            <th>Source Type</th>
                                            <th>Source Value</th>
                                        </tr>
                                        </thead>

                                        <tbody class="ui-sortable">

                                        @foreach($homeSections['section4']['subsections'] as $i => $section4)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>
                                                    <select class="form-control" name="homeSections[section4][subsections][{{ $i }}][source_type]">
                                                        <option value="">Select Value</option>
                                                        <option value="category" {{ $homeSections['section4']['subsections'][$i]['source_type'] == 'category' ? 'selected' : '' }}>Category</option>
                                                        <option value="collection" {{ $homeSections['section4']['subsections'][$i]['source_type'] == 'collection' ? 'selected' : '' }}>Collection</option>
                                                        <option value="top_rated" {{ $homeSections['section4']['subsections'][$i]['source_type'] == 'top_rated' ? 'selected' : '' }}>Top Rated</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="homeSections[section4][subsections][{{ $i }}][source_id]" data-selected="{{ $homeSections['section4']['subsections'][$i]['source_id'] }}" >
                                                        <option value="">Select Value</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- section 5--}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Section Five</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="homeSections[section5][title]">Title</label>
                                        <input type="text" name="homeSections[section5][title]" id="homeSections[section5][title]" value="{{$homeSections['section5']['title']}}" class="form-control" placeholder="Title">
                                        <p class="error"></p>
                                    </div>
                                    <table class="table table-vcenter card-table table-hover table-striped swatches-container text-center">
                                        <thead class="header">
                                        <tr>
                                            <th width="3%">#</th>
                                            <th width="30%">Title</th>
                                            <th>Source Type</th>
                                            <th>Source Value</th>
                                        </tr>
                                        </thead>

                                        <tbody class="ui-sortable" >

                                        @foreach($homeSections['section5']['subsections'] as $i => $section5)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>
                                                    <input type="text" name="homeSections[section5][subsections][{{ $i }}][title]" id="homeSections[section5][subsections][{{ $i }}][title]" value="{{ $homeSections['section5']['subsections'][$i]['title'] }}" class="form-control" placeholder="Title">
                                                </td>
                                                <td>
                                                    <select class="form-control" name="homeSections[section5][subsections][{{ $i }}][source_type]">
                                                        <option value="">Select Value</option>
                                                        <option value="category" {{ $homeSections['section5']['subsections'][$i]['source_type'] == 'category' ? 'selected' : '' }}>Category</option>
                                                        <option value="collection" {{ $homeSections['section5']['subsections'][$i]['source_type'] == 'collection' ? 'selected' : '' }}>Collection</option>
                                                        <option value="top_rated" {{ $homeSections['section5']['subsections'][$i]['source_type'] == 'top_rated' ? 'selected' : '' }}>Top Rated</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="homeSections[section5][subsections][{{ $i }}][source_id]" data-selected="{{ $homeSections['section5']['subsections'][$i]['source_id'] }}" >
                                                        <option value="">Select Value</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                Publish
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="btn-list">
                                <button class="btn btn-primary" type="submit" value="apply" name="submitter">
                                    <svg class="icon icon-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M14 4l0 4l-6 0l0 -4"></path>
                                    </svg>
                                    Save

                                </button>

                                <a href="{{Route('pages.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>


                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </form>


@endsection







@section('script')
    <script>
        $(document).ready(function() {
            function loadSourceOptions($select) {
                var sourceType = $select.val();
                var $sourceIdContainer = $select.closest('td').next().find('select');
                var selectedSourceId = $select.closest('td').next().find('select').data('selected');


                if (sourceType === 'top_rated') {
                    $sourceIdContainer.empty();
                    $sourceIdContainer.append('<option value="">Select Value</option>');
                    $sourceIdContainer.fadeOut()

                } else {
                    $sourceIdContainer.fadeIn();

                    var url = '{{route('pages.getSources',':type')}}'.replace(':type', sourceType);
                    $.getJSON(url, function(data) {
                        $sourceIdContainer.empty();
                        $sourceIdContainer.append('<option value="">Select Value</option>')

                        $.each(data, function(index, item) {
                            var selected = item.id == selectedSourceId ? 'selected' : '';

                            var $option = $('<option>', {
                                value: item.id,
                                text: item.name
                            });

                            if (item.id == selectedSourceId) {
                                $option.attr('selected', 'selected');
                            }

                            $sourceIdContainer.append($option);
                        });
                    });
                }
            }

            $('select[name$="[source_type]"]').on('change', function() {
                loadSourceOptions($(this));
            });

            $('select[name$="[source_type]"]').each(function() {
                if ($(this).val() !== 'top_rated') {

                }
                loadSourceOptions($(this));
            });
        });
    </script>
    <script>
        $('#HomeForm').submit(function (e){
            e.preventDefault();
            var formArray =$(this).serializeArray();

            $.ajax({
                url:'{{route('pages.store')}}',
                type : 'post',
                data:formArray,
                dataType:'json',
                success:function (response){
                    if(response.status == true){

                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select").removeClass('is-invalid')

                        Toast.fire({
                            icon: 'success',
                            title: response.msg
                        })

                    }else {
                        handleErrors(response.errors);
                    }

                },error:function (xhr, status, error){
                    var response = JSON.parse(xhr.responseText);
                    handleErrors(response.errors);
                    console.log('Error:', response.errors);

                }
            })
        });
        function handleErrors(errors) {
            $('.error').removeClass('invalid-feedback').html('');
            $("input[type='text'],input[type='number'],select").removeClass('is-invalid');

            $.each(errors, function (key, value) {
                var nameKey = key.replace('.', '][');

                nameKey = nameKey.replace(/\./g, '][');

                nameKey = nameKey.replace('homeSections]', 'homeSections');

                if (nameKey.match(/\]$/) == null) {
                    nameKey += ']';
                }


                var $input = $(`[name='${nameKey}']`);
                $input.addClass('is-invalid');
                $input.siblings('p').addClass('invalid-feedback').html(`${value}`);
            });
        }



    </script>


@endsection
