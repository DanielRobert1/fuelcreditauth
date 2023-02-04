@component('mail::message')
# [{{ config('app.name') }}] Login Attempted from New Device/IP address

We've noticed that your account was accessed from an unrecognized device/IP address. Email: {{ $data['email'] }}

@component('mail::panel')
    Device: {{ $data['device'] }}<br>
    IP Address: {{ $data['ip'] }}<br>
    Time: {{ carbonParse($data['login_at'])->toDateTimeString() }} ({{ carbonParse($data['login_at'])->getTimezone()->getName() }})
@endcomponent

If you don't recognize this activity, please click the button below to contact us
@component('mail::button', ['url' => '#'])
Contact Us
@endcomponent

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
