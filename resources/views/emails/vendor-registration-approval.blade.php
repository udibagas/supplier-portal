@component('mail::message')

Dear Bapak/Ibu Yang Terhormat.

Terimakasih telah mendaftar untuk menjadi rekanan kami.
Kami telah melakukan verifikasi data yang Anda kirimkan dan kami nyatakan perusahaan Anda terdaftar sebagai rekanan kami.
Silakan login ke Aplikasi Supplier Portal untuk submit invoice atau mengirimkan quotation berdasarkan request yang kami buat.

<strong>Note:</strong><br>
{{nl2br($review->note)}}

@component('mail::button', ['url' => url('/')])
KLIK DI SINI UNTUK LOGIN
@endcomponent

Terimakasih,
<br><br><br>
{{ config('app.name') }}
@endcomponent
