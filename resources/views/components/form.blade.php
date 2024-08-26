<form
    @if($action) action="{{ $action }}" @endif
    @if($method) method="{{ $method }}" @endif
    @if($wire) wire:submit="{{ $wire }}" @endif
    class="form"
    >
    @if($method !== 'GET') @csrf @endif
    {{ $slot }}
</form>