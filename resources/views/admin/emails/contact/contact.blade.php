@include('admin.emails.layout.header')

<div class="content">
    <h1>Contact Form Submission</h1>
    <p>Hello,</p>
    <p>
         New Contact Form Submission on {{ config('app.name') }}.
    </p>
    <p>You have received a new message from the contact form on your website.</p>
    <p>Here are the details:</p>
    <ul>
        <li><strong>Name:</strong> {{ $contact['name'] }}</li>
        <li><strong>Email:</strong> {{ $contact['email'] }}</li>
        <li><strong>Subject:</strong> {{ $contact['subject'] }}</li>
        <li><strong>Phone:</strong> {{ $contact['phone'] }}</li>
        <li><strong>Message:</strong> {{ $contact['message'] }}</li>
    </ul>
</div>

@include('admin.emails.layout.footer')
