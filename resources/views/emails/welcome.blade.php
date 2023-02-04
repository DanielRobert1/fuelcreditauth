@component('mail::message')
<h2>Hello {{$user['name']}},</h2>

<p>Thank you for signing up on {{ config('app.name') }}</p>
<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fugit mollitia quo ut sint voluptatem velit aperiam molestias, fugiat obcaecati earum nemo? Voluptate error, doloremque necessitatibus ut voluptates perspiciatis ratione sapiente.</p>
<p>If you have questions, please email us at <a href="mailto:info@fuelcredit.com">info@fuelcredit.com</a> or call <a href="tel:09090904426">0909 090 4226</a>.</p>

Best regards,<br>
{{ config('app.name') }} Team
@endcomponent