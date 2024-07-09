@extends('admin.master')

@section('style')
    <style>

        .card-header{
            border-bottom: 1px solid rgba(4,32,69,.1);
        }

    </style>
@endsection

@section('title')Contact @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('contact.index')}}">Contact</a></li>
    <li class="breadcrumb-item active">View Contact</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>View Contact</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('contact.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">
                    Contact information
                </h4>
            </div>

            <div class="card-body">
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title"> Name</div>
                        <div class="datagrid-content">{{$contact->name}}</div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Email</div>
                        <div class="datagrid-content"><a href="mailto:{{$contact->email}}">{{$contact->email}}</a></div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Phone</div>
                        <div class="datagrid-content"><a href="tel:{{$contact->phone}}">{{$contact->phone}}</a></div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Time</div>
                        <div class="datagrid-content">{{\carbon\Carbon::parse($contact->created_at)->format('d M,Y H:i:s')}}</div>
                    </div>

                    <div class="datagrid-item">
                        <div class="datagrid-title">Subject</div>
                        <div class="datagrid-content">{{$contact->subject}}</div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">
                    CONTENT
                </h4>
            </div>

            <div class="card-body">
                <p>{{$contact->message}}</p>

            </div>
        </div>
    </div>

@endsection







@section('script')

@endsection
