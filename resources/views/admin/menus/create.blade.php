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
@section('title')Menu - create @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item active">Menu Manager</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create a new menu</h1>
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
                                    <select name="id">
                                        @foreach($menus as $menu)
                                            <option value="{{$menu->id}}">{{$menu->title}}</option>

                                        @endforeach
                                    </select>
                                    <button class="btn btn-sm btn-default btn-menu-select">Select</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="post" action="{{route('menus.create-menu')}}">
            @csrf

          <div class="row mt-5" id="main-row">
            <div class="col-md-3 cat-form disabled">
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
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="panel-heading">
                                <a href="#custom-links" data-toggle="collapse" data-parent="#menu-items" >
                                    Custom Links  <i class="fas fa-caret-down float-right"></i>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

                    <div class="col-md-6 cat-view">
                        <div class="card" id="menu-content">
                            <div class="card-header">
                                <h3><span>Create New Menu</span></h3>
                            </div>
                            <div class="card-body">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label>Name</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="text" name="title" class="form-control {{ $errors->has('title')?'is-invalid':'' }}" value="{{ old('title') }}" placeholder="Menu Name">
                                                @if ($errors->has('title'))
                                                    <p class="invalid-feedback">{{ $errors->first('title') }}</p>
                                                @endif
                                            </div>
                                        </div>
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
                                    <button class="btn btn-primary" type="submit" value="apply" name="submitter">
                                        <svg class="icon icon-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                                            <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                            <path d="M14 4l0 4l-6 0l0 -4"></path>
                                        </svg>
                                        Create Menu
                                    </button>
                                    <a href="{{Route('menus.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                                </div>
                            </div>
                        </div>

                    </div>


        </div>

        </form>

    </div>
@endsection







@section('script')


@endsection
