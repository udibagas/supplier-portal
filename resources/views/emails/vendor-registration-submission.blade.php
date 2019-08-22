@component('mail::message')

Dear Bapak/Ibu Yang Terhormat.

Perusahaan {{$vendor->business_entity_form}} {{$vendor->name}} telah melakukan pendaftaran untuk menjadi rekanan.
Silakan klik link di bawah ini untuk melakukan review.

@component('mail::button', ['url' => url('/')])
KLIK DI SINI UNTUK REVIEW
@endcomponent

Terimakasih,
<br><br><br>
{{ config('app.name') }}
@endcomponent
