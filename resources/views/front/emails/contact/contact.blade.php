@include('front.emails.layout.header')

<div class="content">

    <h1>Hey, {{$contact->name}} and welcome here 😉</h1>

    <p>Thank you for reaching out to us regarding "{{ $contact['subject'] }}".</p>
    <p>We have received your message and will review it promptly. One of our team members will get back to you as soon as possible.</p>
    <p>Here are the details you provided:</p>
    <ul>
        <li><strong>Name:</strong> {{ $contact['name'] }}</li>
        <li><strong>Email:</strong> {{ $contact['email'] }}</li>
        <li><strong>Subject:</strong> {{ $contact['subject'] }}</li>
        <li><strong>Phone:</strong> {{ $contact['phone'] }}</li>
        <li><strong>Message:</strong> {{ $contact['message'] }}</li>
    </ul>

</div>

@include('front.emails.layout.footer')
