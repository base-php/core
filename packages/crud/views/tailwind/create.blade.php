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

                            @if(!empty($types) && in_array($field, array_keys($types)))
                                @if($types[$field] == 'image' || $types[$field] == 'file')
                                    <x-input type="file" name="{{ $field }}" required/>

                                @elseif(is_array($types[$field]) && $types[$field][0] == 'select')
                                    <select name="{{ $field }}" id="{{ $field }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value=""></option>

                                        @foreach($types[$field][1] as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>

                                @elseif(is_array($types[$field]) && $types[$field][0] == 'checkbox')
                                    <div>
                                        @foreach($types[$field][1] as $key => $value)
                                            <input type="checkbox" name="{{ $field }}" value="{{ $value }}"> {{ $key }}
                                        @endforeach
                                    </div>

                                @elseif(is_array($types[$field]) && $types[$field][0] == 'checkbox')
                                    <div>
                                        @foreach($types[$field][1] as $key => $value)
                                            <input type="radio" name="{{ $field }}" value="{{ $value }}"> {{ $key }}
                                        @endforeach
                                    </div>

                                @elseif($types[$field] == 'datetime')
                                    <x-input type="datetime-local" name="{{ $field }}" required/>

                                @else
                                    <x-input type="{{ $types[$field] }}" name="{{ $field }}" required/>
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
