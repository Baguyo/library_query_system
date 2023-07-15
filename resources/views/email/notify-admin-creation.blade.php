<x-mail::message>
Hello Admin! {{ $name }} This is your login credentials to login in our system.

{{-- # Panel component: --}}
@component('mail::panel')
    Email: {{ $email }}
@endcomponent

@component('mail::panel')
    Password: {{ $password }}
@endcomponent




{{-- The body of your message. --}}

<x-mail::button :url="config('app.url')">
Login
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
