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
                                        @if(!empty($types) && in_array($key, array_keys($types)))
                                            @if($types[$key] == 'image')
                                                <td>
                                                    <img src="{{ asset('img/' . $item->$key) }}" width="100px">
                                                </td>
                                            @endif
                                        @else
                                    	   <td>{{ $item->$key }}</td>
                                        @endif
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
                </div>
            </div>
        </div>
    </div>
</x-{{ $layout }}>