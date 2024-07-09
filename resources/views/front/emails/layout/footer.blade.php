<p>
    If you have any questions, feel free to reply to this email or contact our support team.
</p>
<div class="social-icons">
    @include('front.layouts.include.social')
</div>
<p>
    Best regards,<br>
    The {{ config('app.name') }} Team
</p>
<div class="footer">
    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
    Contact us: <a href="mailto:{{ config('settings.store_email') }}">{{ config('settings.store_email') }}</a> | Phone: {{ config('settings.store_phone') }}
</div>
</div>
</body>
</html>

