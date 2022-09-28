@php
    $qrcode = QrCode::encoding('UTF-8')->size(300)->generate($trolley->code);
    $qrcode = str_replace($xml,'',$qrcode);
@endphp
<p style="text-align: center;">
    {!! $qrcode !!}

    <br><br><br>
    <span>Code : {{ $trolley->code }}</span>
</p>