<x-{{ $layout }} title="{{ lang('Edit ' . $route) }}" active="{{ $route }}">
    <div class="w-full p-3">
        <form action="/{{ $route }}/update" method="POST" enctype="multipart/form-data">
            <h1 class="text-4xl">{{ lang('Edit ' . $route) }}</h1>

            <hr class="my-5">

            <x-alert/>

            <div class="flex">
                <div class="w-12/12 rounded bg-white p-7">
                	<x-input type="hidden" name="id" value="{{ $item->id }}"/>

                    @foreach($fields as $field)
                        <div class="mt-5">
                            <x-label for="{{ $field }}" text="{{ lang($field) }}"/>
                            <x-input name="{{ $field }}" required type="{{ $field }}" value="{{ $item->$field }}"/>
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
