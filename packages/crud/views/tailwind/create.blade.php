<x-{{ $layout }} active="{{ $route }}">
    <div class="w-full p-3">
        <form action="/{{ $route }}/store" method="POST" enctype="multipart/form-data">
            <h1 class="text-4xl">{{ lang('Create new ' . $route) }}</h1>

            <hr class="my-5">

            <x-alert/>

            <div class="flex">
                <div class="w-12/12 rounded bg-white p-7">
                    @foreach($fields as $field)
                        <div class="mt-5">
                            <x-label for="{{ $field }}" text="{{ lang($field) }}"/>

                            @if(!empty($types) && in_array($key, array_keys($types)))
                                @if($types[$key] == 'image' || $types[$key] == 'file')
                                    <x-input type="file" name="{{ $field }}" required/>

                                @elseif($types[$key] == 'datetime')
                                    <x-input type="datetime-local" name="{{ $field }}" required/>

                                @else
                                    <x-input type="{{ $types[$key] }}" name="{{ $field }}" required/>
                                @endif
                            @else
                               <x-input name="{{ $field }}" required/>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-5 text-right">
                <x-button color="black">
                    <i class="fa fa-save mr-2"></i>
                    {{ lang('Save') }}
                </x-button>
            </div>
        </form>
    </div>
</x-{{ $layout }}>
