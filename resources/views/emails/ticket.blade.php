@component('mail::message')
{{ $details['title'] }}

Estimad@ usuario:<br>
<br>
<br>

{{ $details['body'] }}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent

