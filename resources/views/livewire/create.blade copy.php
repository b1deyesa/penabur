<div class="container">
          
    {{-- Step 1 --}}
    @if ($step == 1)
    <section class="type">
        @foreach ($types as $key => $type)
            <x-button wire="setType({{ $key }})" :class="$key == $type ? selection : ''">{{ $type }}</x-button>
        @endforeach
    </section>
    
    {{-- Step 2 --}}
    @elseif ($step == 2)
    <section class="year">
        @foreach ($years as $year)
        <x-modal class="modal-create">
            <x-slot:trigger>
                <x-button wire="setYear({{ $year }})">{{ $year }}</x-button>
            </x-slot:trigger>
            <h5>Pilih Bulan</h5>
            <p>Apakah anda ingin memilih bulan yang akan tercantum di dalam sertifikat ini?</p>
            <div class="buttons">
                <x-button wire="chooseMonth(0)">Terserah</x-button>
                <x-button wire="chooseMonth(1)">Pilih</x-button>
            </div>
        </x-modal>
        @endforeach
    </section>
    
    {{-- Step 3 --}}
    @elseif ($step == 3)
    <section class="month">
        @foreach ($months as $key => $month)
            <x-button wire="setMonth({{ $key }},{{ $key }},{{ true }})">{{ $month }}</x-button>
        @endforeach
    </section>
    
    {{-- Step 4 --}}
    @elseif ($step == 4)
    <section class="data">
        <div class="left">
            <label class="label">Foto</label>
            @if ($photo)
                <div class="image">
                    <img src="{{ $photo->temporaryUrl() }}">
                    <div class="buttons">
                        <x-button wire="removePhoto()">Hapus</x-button>
                        <x-button>Ganti</x-button>
                    </div>
                </div>
            @else
                <x-input type="drop-file" wire="photo" placeholder="Pilih atau Drop" description="Foto yang direkomendasikan berukuran 3x4" />
            @endif
        </div>
        <div class="right">
            <x-input type="text" label="Nama" wire="name" placeholder="Nama Lengkap" />
            <div class="date">
                <x-input type="text" label="Waktu Mulai" :value="$date['start']['day'].' '.$months[$date['start']['month']].' '.$date['start']['year']" :disabled="true" />
                <x-input type="text" label="Waktu Selesai" :value="$date['end']['day'].' '.$months[$date['end']['month']].' '.$date['end']['year']" :disabled="true" />
            </div>
            <x-modal class="modal-create">
                <x-slot:trigger>
                    <x-button>Simpan</x-button>
                </x-slot:trigger>
                <h5>Konfirmasi</h5>
                <p>Yakin @if(!$photo)<b>tidak menggunakan foto</b>@endif datanya sudah benar?</p>
                <div class="buttons">
                    <x-button x-on:click="open = false">Tidak</x-button>
                    <x-button x-on:click="open = false" wire="save()">Ya</x-button>
                </div>
            </x-modal>
        </div>
    </section>
    
    {{-- Step 5 --}}
    @elseif ($step == 5)
    @php
        $start_day = $sertifikat->date('start', 'day');
        $start_month = $sertifikat->date('start', 'month');
        $start_year = $sertifikat->date('start', 'year');
        $end_day = $sertifikat->date('end', 'day');
        $end_month = $sertifikat->date('end', 'month');
        $end_year = $sertifikat->date('end', 'year');
    @endphp
    <section class="result">
        <div class="certificate">
            <img src="{{ asset('asset/img/sertifikat.png') }}" alt="Sertifikat" class="background">
            <span class="serial-number">Nomor: {{ substr($end_year, 2, 2) . $end_month . $end_day . $sertifikat->number }} {{ $sertifikat->type == '1' ? 'E.' : '' }} {{ $sertifikat->roman('year') }}/PC/{{ $sertifikat->roman('month') }}/{{ $end_year }}</span>
            <span class="name">{{ $name }}</span>
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
                {{ $date['end']['day'] }} 
                {{ $months[$date['end']['month']] }} 
                {{ $date['end']['year'] }} 
            </span>
            @if ($sertifikat->photo && $show_photo)
                <img src="{{ asset('storage/sertifikat/'. $sertifikat->photo) }}" class="photo">
            @endif
        </div>
        @if ($sertifikat->photo)
            <x-input type="checkbox" wire:model.live="show_photo" :options="json_encode([1 => 'Tampilkan Foto'])" />
        @endif
        <div class="buttons">
            <x-button onclick="location.reload();">Buat Baru</x-button>
            <x-button>Legalisir</x-button>
            <x-button onclick="window.print();">Cetak Warna</x-button>
        </div>
    </section>
    @endif
    
</div>