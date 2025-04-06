{{--load Amiri font from google  --}}
<link href="https://fonts.googleapis.com/css2?family=Amiri&display=swap" rel="stylesheet">

{{-- Plate Design --}}
{{-- The plate design is a div with a background image of the plate and text elements for the numbers and codes --}}
{{-- The text is positioned absolutely within the div to place it correctly on the plate --}}

{{-- Plate Container --}}
<div style="
    width: 260px;
    height: 138px;
    background-image: url('{{ asset('images/plate.png') }}');
    background-size: contain;
    background-repeat: no-repeat;
    position: relative;
    direction: rtl;
    font-family: 'tajawal', sans-serif !important;
">
{{--   conver the english letter to arabic --}}


    {{-- Arabic Number (١٠٣٤) --}}
    <div style="color:black;position: absolute; top: 30px; right: 34px; font-size: 37px;">
        {{ $number_ar }}
    </div>

    {{-- English Number (0346) --}}
    <div style="color:black;position: absolute; top: 75px; right: 25px; font-size:37px; letter-spacing: 5px;">
        {{ $number_en }}
    </div>

    {{-- Arabic Code (٧) --}}
    <div style="color:black;position: absolute; top: 30px; left: 34px; font-size: 30px;">
        {{ $letter_ar }} {{ $code_ar }}
    </div>

    {{-- English Code (7KH) --}}
    <div style="color:black;position: absolute; top: 75px; left: 20px; font-size: 35px; font-weight: bold;">
        {{ $code_en }}
    </div>
</div>
