<x-{{ $layout }} active="{{ $route }}">
	<div class="w-full p-3">
        <h1 class="text-3xl mb-4">{{ lang($route) }}</h1>

        <div class="grid grid-cols-2 mb-5">
            <div>
                <input x-on:keyup="search($el)" autofocus type="text" placeholder="{{ lang('Search...') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <div class="text-right">
                <a href="/{{ $route }}/create" class="inline-flex items-center p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                    <i class="fa fa-plus mr-2"></i> 
                    {{ lang('Create new ' . $user) }}
                </a>
            </div>
        </div>

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
	                        	@if(!empty($types) && in_array($key, array_keys($types)))
                                    @if($types[$key] == 'image')
                                        <td class="p-2">
                                            <img src="{{ asset('img/' . $item->$key) }}" width="100px">
                                        </td>
                                    @endif
                                @else
                                   <td class="p-2">{{ $item->$key }}</td>
                                @endif
	                        @endforeach

	                        <td class="p-2 text-right">
	                            <a class="hover:text-blue-600 p-1" href="{{{ '/' . $route . '/edit/' . $item->id }}" title="{{ lang('Edit ' . $route) }}">
	                                <fa class="fa fa-edit"></fa>
	                            </a>

	                            <a x-on:click="confirmDelete(event, $el)" class="hover:text-red-600 p-1" href="{{ '/' . $route . '/delete/' . $item->id }}" title="{{ lang('Delete ' . $route) }}">
	                                <fa class="fa fa-trash"></fa>
	                            </a>
	                        </td>
	                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-{{ $layout }}>