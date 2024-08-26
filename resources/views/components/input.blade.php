<div class="input">
    
    @if($label)
        <label for="{{ $id }}" class="label">{{ $label }}@if($required)<span>*</span>@endif</label>
    @endif
    
    @switch($type)
        @case('range')
            <input 
                type="range"
                id="{{ $id }}"
                name="{{ $name }}"
                class="range {{ $class ?? null }}" 
                @if($wire) wire:model="{{ $wire }}" @endif
                @if($min) min="{{ $min }}" @endif
                @if($max) max="{{ $max }}" @endif
                @if($step) step="{{ $step }}" @endif
                @if($value) value="{{ $value }}" @endif
                @if($disabled) disabled @endif
                {{ $attributes }}
                >
            @break
        @case('radio')
            <div class="options">
                @foreach ($options as $key => $option)
                    <label for="{{ $name }}{{ $key }}" class="radio" >
                        <input 
                            type="radio" 
                            id="{{ $name }}{{ $key }}" 
                            name="{{ $name }}" 
                            value="{{ $key }}"
                            @if($class) class="{{ $class }}" @endif
                            @if($wire) wire:model="{{ $wire }}" @endif
                            @if($value) @checked($key === $value) @endif
                            {{ $attributes }}
                            >
                        {{ $option }}
                    </label>
                @endforeach
            </div>
            @break
        @case('checkbox')
            <div class="options">
                @foreach ($options as $key => $option)
                    <label for="{{ $name }}{{ $key }}" class="checkbox">
                        <input 
                            type="checkbox"  
                            id="{{ $name }}{{ $key }}" 
                            name="{{ $name }}[{{ $key }}]" 
                            value="{{ $option }}"
                            @if($class) class="{{ $class }}" @endif
                            @if($wire) wire:model="{{ $wire }}.{{ $key }}" @endif
                            @if($value) @checked(in_array($key, $value)) @endif
                            {{ $attributes }}
                            >
                        {{ $option }}
                    </label>
                @endforeach
            </div>
            @break
        @case('color')
            <input 
                type="color"
                id="{{ $id }}"
                name="{{ $name }}"
                class="color {{ $class ?? null }}" 
                @if($wire) wire:model="{{ $wire }}" @endif
                @if($value) value="{{ $value }}" @endif
                @if($disabled) disabled @endif
                {{ $attributes }}
                > 
            @break
        @case('drop-file')
            <label for="{{ $id }}" class="drop-file">
                <input
                    type="file"
                    id="{{ $id }}"
                    name="{{ $name }}"
                    @if($wire) wire:model="{{ $wire }}" @endif
                    @if($disabled) disabled @endif
                    {{ $attributes }}
                    >
                <small>{{ $description }}</small>
                <span>{{ $placeholder ?? 'Choose or Drop File' }}</span>
            </label>
            @push('scripts')
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const dropFileElement = document.querySelector('.drop-file');
                        const fileInput = document.querySelector('input[type="file"]');            
                        dropFileElement.addEventListener('dragover', function (event) {
                            event.preventDefault();
                            event.stopPropagation();
                            dropFileElement.classList.add('drag-over');
                        });            
                        dropFileElement.addEventListener('dragleave', function (event) {
                            event.preventDefault();
                            event.stopPropagation();
                            dropFileElement.classList.remove('drag-over');
                        });            
                        dropFileElement.addEventListener('drop', function (event) {
                            event.preventDefault();
                            event.stopPropagation();
                            dropFileElement.classList.remove('drag-over');
            
                            const files = event.dataTransfer.files;
                            fileInput.files = files;
                            
                            // Trigger input change event if needed
                            const eventChange = new Event('change', { bubbles: true });
                            fileInput.dispatchEvent(eventChange);
                        });
                    });
                </script>
            @endpush
            @break
        @case('textarea')
            <textarea 
                id="{{ $id }}"
                name="{{ $name }}"
                @if($class) class="{{ $class }}" @endif
                @if($cols) cols="{{ $cols }}" @endif
                @if($rows) rows="{{ $rows }}" @endif
                @if($wire) wire:model="{{ $wire }}" @endif
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                @if($readonly) readonly @endif
                @if($disabled) disabled @endif
                @if($autofocus) autofocus @endif
                {{ $attributes }}
                >@if($value) {{ $value }} @endif</textarea>
            @break
        @case('select')
            <div class="select">
                <select
                    id="{{ $id }}"
                    name="{{ $name }}"
                    @if($class) class="{{ $class }}" @endif
                    @if($wire) wire:model="{{ $wire }}" @endif
                    {{ $attributes }}
                    >
                    @if($placeholder) <option value="" selected disabled>{{ $placeholder }}</option> @endif
                    @foreach ($options as $key => $option)
                        <option value="{{ $key }}" @selected($key === $value)>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            @break
        @default
            <input
                type="{{ $type }}"
                id="{{ $id }}"
                name="{{ $name }}"
                @if($class) class="{{ $class }}" @endif
                @if($wire) wire:model="{{ $wire }}" @endif
                @if($value) value="{{ $value }}" @endif
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
                @if($readonly) readonly @endif
                @if($disabled) disabled @endif
                @if($autofocus) autofocus @endif
                {{ $attributes }}
                >
    @endswitch
    
    @error($name)
        <span class="error">{{ $message }}</span>
    @enderror
    
</div>