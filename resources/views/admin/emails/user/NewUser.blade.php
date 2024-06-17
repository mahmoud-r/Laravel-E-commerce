@include('admin.emails.layout.header')

<div class="content">
        <h1>New Customer Registration</h1>
         <p>Hello,{{$admin}}</p>
        <p>
            A new customer has registered on {{ config('app.name') }}.
        </p>
        <p>
            <strong>Name:</strong> {{ $user->name }}<br>
            <strong>Email:</strong> {{ $user->email }}<br>
            <strong>Registered At:</strong> {{ $user->created_at->format('F j, Y, g:i a') }}
        </p>
        <p>
            You can view and manage this customer in the admin dashboard.
        </p>
        <a href="{{ route('users.edit',$user->id) }}" class="button">View Customer</a>
    </div>

@include('admin.emails.layout.footer')
