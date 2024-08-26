<x-layout.app>
    
    {{-- Header --}}
    <header>
        <img src="{{ asset('asset/img/logo.png') }}" class="banner">
        <div class="text">
            <h1>Penabur Computech</h1>
            <h4>Sertifikat Operator Komputer</h4>
        </div>
    </header>
    
    {{-- Content --}}
    <section class="content result">
        <div class="certificate">
            <img src="{{ asset('asset/img/sertifikat.png') }}" alt="Sertifikat" class="background">
            <span class="serial-number">Nomor: {{ $sertifikat->number }} {{ $sertifikat->type == '1' ? 'E.' : '' }} {{ $sertifikat->roman('year') }}/PC/{{ $sertifikat->roman('month') }}/{{ $end_year }}</span>
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
            <img src="{{ asset('storage/sertifikat/foto/'. $sertifikat->photo) }}" class="photo">
        </div>
        <div class="buttons">
            <x-button type="link" href="{{ route('sertifikat.print', ['number' => $sertifikat->number]) }}?grayscale=0&copies=1">Cetak Warna</x-button>
            <x-form action="{{ route('sertifikat.print', ['number' => $sertifikat->number]) }}" method="GET">
                <input type="hidden" name="grayscale" value="1">
                <x-input type="number" name="copies" value="2" />
                <x-button type="submit">Legalisir</x-button>
            </x-form>

            <x-button type="link" href="{{ route('index') }}">Buat Baru</x-button>
        </div>
        
    </section>
    
</x-layout.app>