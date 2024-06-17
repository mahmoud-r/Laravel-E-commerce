@include('front.emails.layout.header')

<div class="content">
    <h1>Hello, {{$user->name}}!</h1>
    <p>
        Welcome to {{ config('app.name') }}! We are thrilled to have you on board.
    </p>
    <p>
        At {{ config('app.name') }}, we strive to provide the best service possible. Below you will find some useful links to get you started:
    </p>
    <a href="{{ url('/') }}" class="button">Visit Our Website</a>

</div>

@include('front.emails.layout.footer')
