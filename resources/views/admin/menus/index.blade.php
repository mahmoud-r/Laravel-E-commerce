@extends('admin.master')


@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">

    <style>
        .menu-item-bar{background: #eee;padding: 5px 10px;border:1px solid #d7d7d7;margin-bottom: 5px; width: 75%; cursor: move;display: block;}
        #serialize_output{display: none;}
        .menulocation label{font-weight: normal;display: block;}
        body.dragging, body.dragging * {cursor: move !important;}
        .dragged {position: absolute;z-index: 1;}
        ol.example li.placeholder {position: relative;}
        ol.example li.placeholder:before {position: absolute;}
        #menuitem{list-style: none;}
        #menuitem ul{list-style: none;}
        .input-box{width:75%;background:#fff;padding: 10px;box-sizing: border-box;margin-bottom: 5px;}
        .input-box .form-control{width: 100%}
        .menulocation label{font-weight: normal;display: block;}
        .item-list,.info-box{background: #fff;padding: 10px;}
        .item-list-body{max-height: 300px;overflow-y: scroll;}
        .panel-body p{margin-bottom: 5px;}
        .info-box{margin-bottom: 15px;}
        .item-list-footer{padding-top: 10px;}
        .panel-heading a{display: block;}
        .form-inline{display: inline;}
        .form-inline select{padding: 4px 10px;}
        .btn-menu-select{padding: 4px 10px}
        .disabled{pointer-events: none; opacity: 0.7;}
    </style>
    <style>
        .card-header{
            border-bottom: 1px solid rgba(4,32,69,.1);
        }
        .panel-heading a{
            font-weight: 500;
            color: black;
        }
        .item-list-footer{
            display: flex;
            justify-content: space-between;
        }
        .dd-item{
            /*max-width: 70%;*/
        }
        .show-item-details{
            background-color: #f6f8fb;
            display: inline-flex;
            height: 38px;
            align-items: center;
            justify-content: center;
            width: 10%;
        }
        .dd-handle{
            border: 0;
            background: transparent;

        }
        .dd-item .card-body{
            border-top: 1px solid rgba(4,32,69,.1);

        }
        .dd-item>button{
            display: none;
        }
    </style>
@endsection
@section('title')Menu Manager @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item active">Menu Manager</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Menus</h1>
                </div>
                <div class="col-sm-6 text-right">
{{--                    <a href="{{Route('discount.index')}}" class="btn btn-primary">Back</a>--}}
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            @if(count($menus) > 0)
                                Select a menu to edit:
                                <form action="{{route('menus.index')}}" class="form-inline">
                                    <select name="id" class="form-control">
                                        @foreach($menus as $menu)
                                            @if($desiredMenu != '')
                                                <option value="{{$menu->id}}" {{$menu->id == $desiredMenu->id ?'selected':''}}>{{$menu->title}}</option>
                                            @else
                                                <option value="{{$menu->id}}">{{$menu->title}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <button class="btn btn-sm btn-default btn-menu-select">Select</button>
                                </form>
                            @can('menu-create')
                                or <a href="{{route('menus.create')}}">Create a new menu</a>.
                            @endcan

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5" id="main-row">
            <div class="col-md-3 cat-form @if(count($menus) == 0) disabled @endif">
                <h3><span>Add Menu Items</span></h3>

                <div class="panel-group" id="menu-items">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="panel-heading">
                                <a href="#categories-list" data-toggle="collapse" data-parent="#menu-items" >
                                   Categories  <i class="fas fa-caret-down float-right"></i>
                                </a>

                            </div>
                        </div>
                        <div id="categories-list" class="panel-collapse collapse in">
                            <div class="card-body">
                                <div class="panel-body">
                                    <div class="item-list-body">
                                        @foreach($categories as $cat)
                                            <div class="custom-control custom-checkbox mt-2">
                                                <input type="checkbox" class="custom-control-input" id="select-category{{$cat}}" value="{{$cat->id}}" name="select-category[]" >
                                                <label for="select-category{{$cat}}" class="custom-control-label">{{$cat->name}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="item-list-footer">
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" class="custom-control-input " id="select-all-categories"  >
                                        <label for="select-all-categories" class="custom-control-label">Select All</label>
                                    </div>
                                    <button type="button" class="pull-right dt-button btn dt-btn " id="add-categories">Add to Menu</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="panel-heading">
                                <a href="#pages-list" data-toggle="collapse" data-parent="#menu-items" >
                                    Pages <i class="fas fa-caret-down float-right"></i>
                                </a>

                            </div>
                        </div>
                        <div id="pages-list" class="panel-collapse collapse in" >
                            <div class="card-body">
                                <div class="panel-body">
                                    <div class="item-list-body">
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" id="home-page" data-url="{{route('home')}}" value="Home" name="pages[]">
                                            <label for="home-page" class="custom-control-label">Home</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" id="shop-page" data-url="{{route('front.shop')}}" value="Shop" name="pages[]">
                                            <label for="shop-page" class="custom-control-label">Shop</label>
                                        </div>

                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" id="contact-page" data-url="{{route('front.page.contact')}}" value="Contact" name="pages[]">
                                            <label for="contact-page" class="custom-control-label">Contact Us</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" id="about-page" data-url="{{route('front.page.about')}}" value="about" name="pages[]">
                                            <label for="about-page" class="custom-control-label">about</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" id="term-condition-page" data-url="{{route('front.page.term-condition')}}" value="term & condition" name="pages[]">
                                            <label for="term-condition-page" class="custom-control-label">term & condition</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" id="profile-page" data-url="{{route('front.profile')}}" value="my account" name="pages[]">
                                            <label for="profile-page" class="custom-control-label">my account</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" id="wishlist-page" data-url="{{route('front.wishlist.index')}}" value="wishlist" name="pages[]">
                                            <label for="wishlist-page" class="custom-control-label">wishlist</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" id="cart-page" data-url="{{route('front.cart')}}" value="cart" name="pages[]">
                                            <label for="cart-page" class="custom-control-label">cart</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="item-list-footer" >
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" class="custom-control-input " id="select-all-pages"  >
                                        <label for="select-all-pages" class="custom-control-label">Select All</label>
                                    </div>
                                    <button type="button" class="pull-right dt-button btn dt-btn " id="add-Pages">Add to Menu</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="panel-heading">
                                <a href="#custom-links" data-toggle="collapse" data-parent="#menu-items" >
                                    Custom Links  <i class="fas fa-caret-down float-right"></i>
                                </a>

                            </div>
                        </div>
                        <div id="custom-links" class="panel-collapse collapse in" >
                            <div class="card-body">
                                <div class="panel-body">
                                    <div class="item-list-body">
                                        <div class="form-group">
                                            <label>URL</label>
                                            <input type="url" id="url" class="form-control" placeholder="https://">
                                        </div>
                                        <div class="form-group">
                                            <label>Link Text</label>
                                            <input type="text" id="linktext" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="item-list-footer" style="justify-content: flex-end">

                                    <button type="button" class="pull-right dt-button btn dt-btn " id="add-custom-link">Add to Menu</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 cat-view">
                <div class="card" id="menu-content">
                    <div class="card-header">
                        <h3><span>Menu Structure</span></h3>
                    </div>
                    <div class="card-body">
                        <div style="min-height: 240px;">
                            @if($desiredMenu != '')
                                <div class="dd" id="nestable">
                                    <ol class="dd-list">
                                        @if(!empty($menuitems))
                                            @foreach($menuitems as $key =>$item)
                                                <li class="dd-item" data-id="{{ $item->id }}">
                                                    <div class="card">
                                                        <div class="" style="display: flex;justify-content: space-between;align-items: center;">
                                                            <div class="dd-handle card-header" style="width: 90%;">
                                                                @if(empty($item->name)) {{ $item->title }} @else {{ $item->name }} @endif
                                                            </div>
                                                            <span class="mr-3">{{$item->type}}</span>
                                                            <a href="#collapse{{ $item->id }}" class="pull-right show-item-details" data-toggle="collapse"><i class="fas fa-caret-down float-right"></i></a>

                                                        </div>

                                                        <div class="collapse card-body" id="collapse{{ $item->id }}">
                                                            <div class="input-box">
                                                                <form method="post" action="{{route('menus.updateMenuItem', $item->id)}}">
                                                                    {{ csrf_field() }}
                                                                    <div class="form-group">
                                                                        <label>Link Name</label>
                                                                        <input type="text" name="name" value="@if(empty($item->name)) {{ $item->title }} @else {{ $item->name }} @endif" class="form-control">
                                                                    </div>
                                                                    @if($item->type == 'custom' || $item->type == 'page')
                                                                        <div class="form-group">
                                                                            <label>URL</label>
                                                                            <input type="text" name="slug" value="{{ $item->slug }}" class="form-control">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input type="hidden" name="target" value="_self">
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input class="custom-control-input location" type="checkbox" id="Navigation-radio{{$item->id}}" name="target" value="_blank" {{$item->target == '_blank' ? 'checked':''}}>
                                                                                <label for="Navigation-radio{{$item->id}}" class="custom-control-label">Open in a new tab</label>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    <div class="form-group">
                                                                        <button class="btn btn-sm btn-primary">Save</button>
                                                                        <a href="{{route('menus.deleteMenuItem',['id'=>$item->id,'key'=>$key,'in'=>'','in2'=>''])}}" class="btn btn-sm btn-danger">Delete</a>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if(isset($item->children))
                                                        <ol class="dd-list" style="    padding-left: 30px;">
                                                            @foreach($item->children as $i => $child)
                                                                <li class="dd-item" data-id="{{ $child->id }}">
                                                                    <div class="card">
                                                                        <div class="" style="display: flex;justify-content: space-between;align-items: center;">
                                                                            <div class="dd-handle card-header" style="width: 90%;">
                                                                                @if(empty($child->name)) {{ $child->title }} @else {{ $child->name }} @endif
                                                                            </div>
                                                                            <span class="mr-3">{{$child->type}}</span>
                                                                            <a href="#collapse{{ $child->id }}" class="pull-right show-item-details" data-toggle="collapse"><i class="fas fa-caret-down float-right"></i></a>

                                                                        </div>

                                                                        <div class="collapse card-body" id="collapse{{ $child->id }}">
                                                                            <div class="input-box">
                                                                                <form method="post" action="{{route('menus.updateMenuItem',$child->id)}}">
                                                                                    {{ csrf_field() }}
                                                                                    <div class="form-group">
                                                                                        <label>Link Name</label>
                                                                                        <input type="text" name="name" value="@if(empty($child->name)) {{ $child->title }} @else {{ $child->name }} @endif" class="form-control">
                                                                                    </div>
                                                                                    @if($child->type == 'custom'|| $item->type == 'page')
                                                                                        <div class="form-group">
                                                                                            <label>URL</label>
                                                                                            <input type="text" name="slug" value="{{ $child->slug }}" class="form-control">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <input type="hidden" name="target" value="_self">
                                                                                            <div class="custom-control custom-checkbox">
                                                                                                <input class="custom-control-input location" type="checkbox" id="Navigation-radio{{$child->id}}{{$i}}" name="target" value="_blank" {{$child->target == '_blank' ? 'checked':''}}>
                                                                                                <label for="Navigation-radio{{$child->id}}{{$i}}" class="custom-control-label">Open in a new tab</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                    <div class="form-group">
                                                                                        <button class="btn btn-sm btn-primary">Save</button>
                                                                                        <a href="{{route('menus.deleteMenuItem',['id'=>$child->id,'key'=>$i,'in'=>$key,'in2'=>''])}}" class="btn btn-sm btn-danger">Delete</a>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @if(isset($child->children))
                                                                        <ol class="dd-list" style="    padding-left: 30px;">
                                                                            @foreach($child->children as $k => $child)
                                                                                <li class="dd-item" data-id="{{ $child->id }}">
                                                                                    <div class="card">
                                                                                        <div class="" style="display: flex;justify-content: space-between;align-items: center;">
                                                                                            <div class="dd-handle card-header" style="width: 90%;">
                                                                                                @if(empty($child->name)) {{ $child->title }} @else {{ $child->name }} @endif
                                                                                            </div>
                                                                                            <span class="mr-3">{{$child->type}}</span>
                                                                                            <a href="#collapse{{ $child->id }}" class="pull-right show-item-details" data-toggle="collapse"><i class="fas fa-caret-down float-right"></i></a>

                                                                                        </div>

                                                                                        <div class="collapse card-body" id="collapse{{ $child->id }}">
                                                                                            <div class="input-box">
                                                                                                <form method="post" action="{{route('menus.updateMenuItem',$child->id)}}">
                                                                                                    {{ csrf_field() }}
                                                                                                    <div class="form-group">
                                                                                                        <label>Link Name</label>
                                                                                                        <input type="text" name="name" value="@if(empty($child->name)) {{ $child->title }} @else {{ $child->name }} @endif" class="form-control">
                                                                                                    </div>
                                                                                                    @if($child->type == 'custom' || $item->type == 'page')
                                                                                                        <div class="form-group">
                                                                                                            <label>URL</label>
                                                                                                            <input type="text" name="slug" value="{{ $child->slug }}" class="form-control">
                                                                                                        </div>
                                                                                                        <div class="custom-control custom-checkbox">
                                                                                                            <input class="custom-control-input location" type="checkbox" id="Navigation-radio{{$child->id}}{{$k}}" name="target" value="_blank" {{$child->target == '_blank' ? 'checked':''}}>
                                                                                                            <label for="Navigation-radio{{$child->id}}{{$k}}" class="custom-control-label">Open in a new tab</label>
                                                                                                        </div>
                                                                                                    @endif
                                                                                                    <div class="form-group">
                                                                                                        <button class="btn btn-sm btn-primary">Save</button>
                                                                                                        <a href="{{route('menus.deleteMenuItem',['id'=>$child->id,'key'=>$k,'in'=>$key,'in2'=>$i])}}" class="btn btn-sm btn-danger">Delete</a>
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        </ol>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ol>
                                                    @endif
                                                </li>
                                            @endforeach


                                        @endif
                                    </ol>
                                </div>
                                <pre id="serialize_output">{{$desiredMenu->content}}</pre>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <!-- sidebar-->
            <div class="col-md-3">

                <!-- Publish-->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Publish</h4>
                    </div>
                    <div class="card-body">
                        <div class="btn-list">
                            @can('menu-edit')
                            <button class="btn btn-primary" id="saveMenu">
                                <svg class="icon icon-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                                    <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                    <path d="M14 4l0 4l-6 0l0 -4"></path>
                                </svg>
                                Save
                            </button>
                            @endcan
                            @can('menu-delete')
                            <a href="{{route('menus.destroy',$desiredMenu->id)}}" class="btn btn-danger ml-3">Delete </a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Menu Name</h4>
                    </div>
                    <div class="card-body">
                        <div class="btn-list">
                            <div class="form-group menulocation">
                                <div class="mb-3">
                                    <input type="text" name="title" id="title" value="{{$desiredMenu->title}}"  class="form-control " placeholder="Name">
                                    <p class="error"></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Menu Location</h4>
                    </div>
                    <div class="card-body">
                        <div class="btn-list">
                            <div class="form-group menulocation">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input location" type="radio" id="header-radio" name="location" value="1" {{$desiredMenu->location == 1 ? 'checked':''}}>
                                    <label for="header-radio" class="custom-control-label">Header</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input location" type="radio" id="footer-one" name="location" value="2" {{$desiredMenu->location == 2 ? 'checked':''}}>
                                    <label for="footer-one" class="custom-control-label">Footer one</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input location" type="radio" id="footer-two" name="location" value="3" {{$desiredMenu->location == 3 ? 'checked':''}}>
                                    <label for="footer-two" class="custom-control-label">Footer two</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input location" type="radio" id="footer-three" name="location" value="4" {{$desiredMenu->location == 4 ? 'checked':''}}>
                                    <label for="footer-three" class="custom-control-label">Footer three</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection







@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>

    <script>
        $('#add-categories').click(function(){
            var menuid = {{$desiredMenu->id}};
            var n = $('input[name="select-category[]"]:checked').length;
            var array = $('input[name="select-category[]"]:checked');
            var ids = [];
            for(i=0;i<n;i++){
                ids[i] =  array.eq(i).val();
            }
            if(ids.length == 0){
                return false;
            }
            $.ajax({
                type:"post",
                data: {menuid:menuid,ids:ids},
                url: "{{route('menus.addCatToMenu')}}",
                success:function(res){
                    location.reload();

                }
            })
        })
        $("#add-custom-link").click(function(){
            var menuid = {{$desiredMenu->id}};
            var url = $('#url').val();
            var link = $('#linktext').val();
            if(url.length > 0 && link.length > 0){
                $.ajax({
                    type:"post",
                    data: {menuid:menuid,url:url,link:link},
                    url: "{{route('menus.addCustomLink')}}",
                    success:function(res){
                        location.reload();
                    }
                })
            }
        })
        $("#add-Pages").click(function(){
            var menuid = {{$desiredMenu->id}};
            var array = $('input[name="pages[]"]:checked');
            var pages = [];

            array.each(function (){
                pages.push({
                    'title': $(this).val(),
                    'url': $(this).data('url')
                });
            });

            $.ajax({
                type:"post",
                data: {menuid:menuid,pages:pages},
                url: "{{route('menus.addPage')}}",
                success:function(res){
                    location.reload();
                }
            })

        })
    </script>
    <script>
        $('#select-all-categories').click(function(event) {
            if(this.checked) {
                $('#categories-list :checkbox').each(function() {
                    this.checked = true;
                });
            }else{
                $('#categories-list :checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
        $('#select-all-pages').click(function(event) {
            if(this.checked) {
                $('#pages-list :checkbox').each(function() {
                    this.checked = true;
                });
            }else{
                $('#pages-list :checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#nestable').nestable({  maxDepth: 3}).on('change', function() {
                var serializedData = $('#nestable').nestable('serialize');
                var jsonString = JSON.stringify(serializedData, null, ' ');
                $('#serialize_output').text(jsonString);
            });
        });
    </script>
    <script>
        $('#saveMenu').click(function(){
            var menuid = {{$desiredMenu->id}};
            var location = $('input[name="location"]:checked').val();
            var title = $('input[name="title"]').val();
            var newText = $("#serialize_output").text();
            var data = JSON.parse($("#serialize_output").text());

            $.ajax({
                type:"post",
                data: {menuid:menuid,data:data,location:location,title:title},
                url: "{{route('menus.updateMenu')}}",
                success:function(res){
                    if(res.status == 'true'){
                        window.location.reload();
                    }else {
                        handleErrors(res.error)
                    }
                }
            })
        })

        //Handel Error
        function handleErrors(errors) {
            $('.error').removeClass('invalid-feedback').html('');
            $("input[type='text'],input[type='number'],select").removeClass('is-invalid');

            $.each(errors, function (key, value) {
                $(`.${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(`${value}`);
            });}

    </script>

@endsection
