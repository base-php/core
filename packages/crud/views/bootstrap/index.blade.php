<x-{{ $layout }} active="{{ $route }}">
    <div>
        <h1>{{ lang($route) }}</h1>

        <div class="row">
            <div class="col-9">
                <input type="text" type="text" autofocus class="form-control" placeholder="{{ lang('Search...') }}">
            </div>

            <div class="col-3">
                <a href="/{{ $route }}/create" class="btn btn-dark btn-block w-100">
                    {{ lang('Create new ' . $user) }}
                </a>
            </div>

            <x-alert></x-alert>

            <div class="card mt-3">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            	@foreach(array_keys($items[0]) as $key)
                                	<th>{{ lang($key) }}</th>
                                @endforeach

                                <th></th>                                
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                	@foreach(array_keys($items[0]) as $key)
                                        <td>
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

                                    <td>
                                        <a class="text-decoration-none text-dark" href="{{ '/' . $route . '/edit/' . $item->id }}" title="{{ lang('Edit ' . $route) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a class="text-decoration-none text-danger" href="{{ '/' . $route . '/delete/' . $item->id }}" title="{{ lang('Delete ' . $route) }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>       
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if(get_class($items) == 'Illuminate\Pagination\LengthAwarePaginator')
                        {{ $items->links('bootstrap', query_string()) }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-{{ $layout }}>