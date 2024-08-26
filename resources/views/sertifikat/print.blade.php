<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <style>
        @page {
            size: A4 landscape;
        }
        @font-face {
            font-family: 'Gill Sans';
            src: url('{{ asset('asset/font/GillSans/GillSans.otf') }}');
        }
        * {
            margin: 0;
            padding: 0;
        }
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .screen {
            position: relative;
            height: 190mm;
            widht: 297mm;
            overflow: hidden;
        }
        .background {
            height: 110%;
            widht: 100%;
        }
        .number {
            position: absolute;
            text-align: center;
            top: 98mm;
            right: 0;
            left: 0;
            font-size: 16.3pt;
            font-weight: bold;
            color: #5a0707;
        }
        .name {
            position: absolute;
            font-family: 
            font-family: 'Gill Sans', sans-serif;
            font-style: italic;
            font-size: 24pt;
            font-weight: bold;
            letter-spacing: -.01em;
            text-align: center;
            text-transform: uppercase;
            bottom: 59mm;
            right: 0;
            left: 0;
        }
        .date {
            position: absolute;
            font-family: 'Gill Sans', sans-serif;
            font-size: 13pt;
            font-style: italic;
            font-weight: normal;
            text-align: center;
            bottom: 40mm;
            right: 0;
            left: 0;
            color: #0d0779;
        }
        .ttd {
            position: absolute;
            font-family: 'Gill Sans', sans-serif;
            font-size: 10pt;
            font-style: italic;
            font-weight: normal;
            text-align: center;
            bottom: 30mm;
            right: -50%;
            left: 0;
            color: #0d0779;
        }
        .photo-container {
            position: absolute;
            width: 2.8cm;
            height: 3.8cm;
            bottom: 0;
            left: 50mm;
            background: #fff;
            overflow: hidden;
        }
        .photo-container img {
            position: absolute;
            top: 50%;
            left: 50%;
            width: auto;
            height: 100%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
    <div class="screen">
        <span class="number">Nomor: {{ $sertifikat->number }} {{ $sertifikat->type == '1' ? 'E.' : '' }} {{ $sertifikat->roman('year') }}/PC/{{ $sertifikat->roman('month') }}/{{ $end_year }}</span>
            <span class="name">{{ $sertifikat->name }}</span>
            <span class="date">Dari Tanggal 
                {{ (int)$start_day }} 
                {{ $start_month !== $end_month ? $months[(int)$start_month] : '' }} 
                {{ $start_year !== $end_year ? $start_year : '' }} 
                s/d 
                {{ (int)$end_day }} 
                {{ $months[(int)$end_month] }} 
                {{ $end_year }} 
            </span>
            <span class="ttd">
                Ambon, 
                {{ (int)$end_day }} 
                {{ $months[(int)$end_month] }} 
                {{ $end_year }} 
            </span>
        <span class="photo-container">
            <img src="{{ public_path('storage/sertifikat/foto/'. $sertifikat->photo) }}">
        </span>
        <img src="{{ public_path('asset/img/sertifikat.png') }}" class="background">
    </div>
</body>
</html>