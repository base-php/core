<x-{{ $layout }} active="{{ $route }}">
    <div class="w-full p-3">
        <form action="/{{ $route }}/store" method="POST" enctype="multipart/form-data">
            <h1 class="text-4xl">{{ lang('Create new ' . $route) }}</h1>

            <hr class="my-5">

            <x-alert/>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @foreach($fields as $field)
                                <div class="mt-3">
                                    <x-label for="{{ $field }}" text="{{ lang($field) }}"/>

                                    @if(!empty($types) && in_array($key, array_keys($types)))
                                        @if($types[$key] == 'image' || $types[$key] == 'file')
                                            <x-input type="file" name="{{ $field }}" required type="{{ $field }}"/>
                                        @endif
                                    @else
                                       <x-input name="{{ $field }}" required type="{{ $field }}"/>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 mb-5 offset-5 col-7">
                <x-button color="dark" border="dark">
                    <i class="fa fa-save mr-2"></i>
                    {{ lang('Save') }}
                </x-button>
            </div>
        </form>
    </div>
</x-{{ $layout }}>
