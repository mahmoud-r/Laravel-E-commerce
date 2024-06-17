<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #218838;
        }
        .social-icons {
            margin: 20px 0;
        }
        .social-icons a {
            margin: 0 10px;
            text-decoration: none;
        }
        .social-icons img {
            width: 24px;
            height: 24px;
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
