<button type="button" class="{{ $class ?? '' }}" onclick="document.getElementById('{{ $id ?? '' }}').click()">
    {{ $slot }}
</button>

<input type="file" name="{{ $id ?? '' }}" id="{{ $id ?? '' }}" style="display: none">
