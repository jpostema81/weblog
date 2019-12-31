@component('mail::message')
# Registration successful

{{ $greeting }}

@component('mail::button', ['url' => 'http://localhost:8000'])
Visit the weblog
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
