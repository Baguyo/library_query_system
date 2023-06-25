<x-mail::message>
You borrow a book of Fullbright College Inc.

Reference:
@component('mail::panel')
    <h1> {{$reference}} </h1>
@endcomponent

If the book is not been picked up within 2 hours the reference code will be invalid
and the book transaction will be deleted.



Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
