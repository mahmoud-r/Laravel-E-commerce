<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F8FA !important;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 10px 0;
        }
        .header img {
            max-width: 150px;
        }
        .content {
            text-align: left;
            padding: 20px 0;
        }
        .content h1 {
            color: #333;
            font-size: 24px;
        }
        .content p {
            color: #666;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            padding: 10px 0;
            font-size: 12px;
            color: #999;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #206bc4;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
        }

        .social-icons {
            margin: 20px 0;
        }
        .social-icons a {
            margin: 0 10px;
            text-decoration: none;
        }
        .social-icons svg {
            width: 24px;
            height: 24px;
        }
        .table {
            width: 100%;
            background-color: transparent;
        }
        .review-button {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .table {
            margin-bottom: 0;
        }
        .table-responsive>.table-bordered {
            border: 0;
        }
        .table td, .table th {
            padding: .75rem;
            vertical-align: top;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
        .table-borderless td, .table-borderless th {
            border: none ;
        }
        .table-vcenter>:not(caption)>*>* {
            vertical-align: middle;
        }
        .gap-2 {
            gap: .5rem !important;
        }
        .align-items-start {
            -ms-flex-align: start !important;
            align-items: flex-start !important;
        }
        .d-flex {
            display: -ms-flexbox !important;
            display: flex !important;
        }
        a {
            color: #007bff;
            text-decoration: none;
            background-color: transparent;
        }
        table {
            border-collapse: collapse;
        }
        .badge {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
        .badge {
            font-size: 80%;
            padding: .25em .5em;
            letter-spacing: .04em;
        }
        .bg-success, .bg-success>a {
            color: #fff !important;
        }
        .bg-success {
            background-color: #28a745 !important;
        }
        .text-warning-fg {
            color: #f6f8fb !important;
        }
        .bg-warning {
            background-color: #f76707 !important;
        }
        .bg-danger, .bg-danger>a {
            color: #fff !important;
        }
        .bg-danger {
            background-color: #dc3545 !important;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        @if(!empty(get_setting('store_logo')))
            <div>
                <img class="logo_dark" src="{{asset('uploads/site/images/'.get_setting('store_logo'))}}" alt="{{get_setting('store_name')}}">
            </div>
        @else
            <img class="logo_dark" src="{{asset('/front_assets/images/logo_dark.png')}}" alt="{{get_setting('store_name')}}">
        @endif
    </div>
