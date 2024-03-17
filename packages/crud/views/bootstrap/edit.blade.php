<x-{{ $layout }} title="{{ lang('Edit ' . $route) }}" active="{{ $route }}">
    <div class="w-full p-3">
        <form action="/{{ $route }}/update" method="POST" enctype="multipart/form-data">
            <h1 class="text-4xl">{{ lang('Edit ' . $route) }}</h1>

            <hr class="my-5">

            <x-alert/>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <x-input type="hidden" name="id" value="{{ $item->id }}"/>

                            @foreach($fields as $field)
                                <div class="mt-3">
                                    <x-label for="{{ $field }}" text="{{ lang($field) }}"/>
                                    
                                    @if(!empty($types) && in_array($key, array_keys($types)))
                                        @if($types[$key] == 'image' || $types[$key] == 'file')
                                            <x-input type="file" name="{{ $field }}" required/>

                                            <div>
                                                @if($types[$key] == 'image')
                                                    <img src="{{ asset('img/' . $item->$key) }}" width="100px">
                                                @endif

                                                @if($types[$key] == 'file')
                                                    <a href="{{ asset('files/' . $item->$field) }}">{{ $item->$field }}</a>
                                                @endif
                                            </div>
                                        @endif

                                        @if($types[$key] == 'date')
                                            <x-input name="date" required value="{{ $item->$field }}"/>
                                        @endif
                                    @else
                                       <x-input name="{{ $field }}" required value="{{ $item->$field }}"/>
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
