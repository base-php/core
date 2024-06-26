<x-{{ $layout }} active="{{ $route }}">
	<div class="w-full p-3">
        <h1 class="text-3xl mb-4">{{ lang($route) }}</h1>

        <div class="grid grid-cols-2 mb-5">
            @if(! count($filters))
                <div>
                    <input x-on:keyup="search($el)" autofocus type="text" placeholder="{{ lang('Search...') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            @endif

            <div class="text-right">
                <a href="/{{ $route }}/create" class="inline-flex items-center p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                    <i class="fa fa-plus mr-2"></i> 
                    {{ lang('Create new ' . $user) }}
                </a>
            </div>
        </div>

        @if(count($filters))
            <div class="grid grid-cols-subgrid mb-5">
                @foreach($filters as $filter)
                    <div>
                        @if($filter->type == 'text')
                            <input type="text" name="{{ $filter->name }}" value="{{ get($filter->name) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @endif

                        @if($filter->type == 'date')
                            <input type="date" name="{{ $filter->name }}" value="{{ get($filter->name) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @endif

                        @if($filter->type == 'select')
                            <select name="{{ $filter->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value=""></option>

                                @foreach($filter->options as $item)
                                    <option {{ $item->id == get($filter->name) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        @if(count($widgets))
            <div class="grid grid-cols-subgrid mb-5">
                @foreach($widgets as $widget)
                    <div>
                        <div class="bg-{{ $widget->color }} text-center text-white">
                            <div>
                                {{ $widget->icon }}
                            </div>

                            <div>
                                {{ $widget->name }}: {{ $widget->value }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <x-alert></x-alert>

        <div class="bg-white border rounded shadow p-5 text-lg">
            <table id="table" class="w-full">
                <thead class="border-b-2">
                    <tr class="hover:bg-gray-100">
                    	@foreach(array_keys($items[0]) as $key)
                        	<th class="text-left p-2">{{ lang($key) }}</th>
                        @endforeach

                        <th class="text-left p-2"></th>
                    </tr>
                </thead>

                <tbody>
                	@foreach($items as $item)
	                    <tr class="hover:bg-gray-100">
	                        @foreach(array_keys($items[0]) as $key)
                                <td class="p-2">
                                    @if(!empty($types) && in_array($key, array_keys($types)))
                                        @if($types[$key] == 'image')
                                            <img src="{{ asset('img/' . $item->$key) }}" width="100px">
                                        @endif

                                        @if($types[$key] == 'file')
                                            <a href="{{ asset('files/' . $item->$key) }}">{{ $item->$key }}</a>
                                        @endif
                                    @else
                                        @if(strpos($key, 'id') === false)
                                            {{ $item->$key }}
                                        @else
                                            @php
                                                $key = str_replace(['id_', '_id'], ['', ''], $key);
                                                $item->$key
                                            @endphp
                                        @endif
                                    @endif
                                </td>
	                        @endforeach

	                        <td class="p-2 text-right">
	                            <a class="hover:text-blue-600 p-1" href="{{{ '/' . $route . '/edit/' . $item->id }}" title="{{ lang('Edit ' . $route) }}">
	                                <i class="fa fa-edit"></i>
	                            </a>

	                            <a x-on:click="confirmDelete(event, $el)" class="hover:text-red-600 p-1" href="{{ '/' . $route . '/delete/' . $item->id }}" title="{{ lang('Delete ' . $route) }}">
	                                <i class="fa fa-trash"></i>
	                            </a>
	                        </td>
	                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if(get_class($items) == 'Illuminate\Pagination\LengthAwarePaginator')
                {{ $items->links('tailwind', query_string()) }}
            @endif
        </div>
    </div>
</x-{{ $layout }}>