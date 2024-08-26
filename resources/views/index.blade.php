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
    <section class="content">
        @livewire('create')
    </section>
    
</x-layout.app>