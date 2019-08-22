@component('mail::message')

Dear Bapak/Ibu Yang Terhormat,

Semoga Bapak/Ibu dalam keadaan sehat selalu.
Dengan ini kami menyampaikan permohonan penawaran dengan detail sebagai berikut.

{{-- TODO : penawaran detail --}}

@component('mail::button', ['url' => ''])
KLIK DISINI UNTUK MENGAJUKAN PENAWARAN
@endcomponent

Terimakasih,
<br><br><br>
{{ config('app.name') }}
@endcomponent
