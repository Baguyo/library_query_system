<x-mail::message>
Hello! {{ $user->name }} This is your login credentials to login in our system.

{{-- # Panel component: --}}
@component('mail::panel')
    Email: {{ $user->email }}
@endcomponent

@component('mail::panel')
    Password: {{ $password }}
@endcomponent




{{-- The body of your message. --}}

<x-mail::button :url="config('app.url')">
Login
</x-mail::button>



Thanks,<br>
FbcLibrary
</x-mail::message>
