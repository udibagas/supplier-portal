@component('mail::message')

Dear Bapak/Ibu Yang Terhormat.

Terimakasih telah mendaftar untuk menjadi rekanan kami.
Kami telah melakukan verifikasi data yang Anda kirimkan dan kami menemukan ada beberapa data yang perlu dilengkapi/dibenahi.
Silakan klik link di bawah ini untuk melakukan perubahan data.

<strong>Note:</strong><br>
{{nl2br($review->note)}}

@component('mail::button', ['url' => url('/')])
KLIK DI SINI UNTUK MERUBAH DATA
@endcomponent

Terimakasih,
<br><br><br>
{{ config('app.name') }}
@endcomponent
