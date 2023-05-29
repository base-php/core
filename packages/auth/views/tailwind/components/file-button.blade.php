<button x-show="{{ $show ?? '' }}" onclick="{{ $click ?? '' }}" type="button" id="{{ $id ?? '' }}" class="btn btn-{{ $background }} border-{{ $border }}">
    {{ $slot }}
</button>
