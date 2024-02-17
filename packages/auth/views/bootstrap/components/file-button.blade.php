<button x-show="{{ $show ?? '' }}" x-on:click="{{ $click ?? '' }}" type="button" id="{{ $id ?? '' }}" class="{{ $class }}">
    {{ $slot }}
</button>
