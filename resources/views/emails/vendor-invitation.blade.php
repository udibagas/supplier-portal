@component('mail::message')

Dear Bapak/Ibu {{$invitation->name}},

Semoga Bapak/Ibu dalam keadaan sehat selalu.

Dengan ini kami mengundang perusahaan Bapak/Ibu ({{$invitation->company_name}}) untuk menjadi partner perusahaan kami.

Besar harapan kami perusahaan Bapak/Ibu dapat bekerjasama dengan kami.

@component('mail::button', ['url' => $invitation->invitation_url])
KLIK DI SINI UNTUK MENDAFTAR
@endcomponent

Terimakasih,
<br><br><br>
{{ config('app.name') }}
@endcomponent
