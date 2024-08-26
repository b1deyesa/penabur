<span x-data="{ open: false }">
    <span class="trigger" x-on:click="open = ! open">{!! $trigger !!}</span>
    <template x-teleport="body">
        <div class="modal {{ $class }}" x-show="open" x-trap="open" x-transition.opacity.80>
            <div class="container" @click.outside="open = false" x-cloak>
                @if($close) <x-button class="close" x-on:click="open = false"><i class="fa-solid fa-xmark"></i></x-button> @endif
                {{ $slot }}
            </div>
        </div>
    </template>
</span>