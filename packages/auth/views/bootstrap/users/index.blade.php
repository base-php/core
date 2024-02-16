<x-template-dashboard active="users">
    <div>
        <h1>{{ lang('Users') }}</h1>

        <div class="row">
            <div class="col-9">
                <input type="text" type="text" autofocus class="form-control" placeholder="{{ lang('Search...') }}">
            </div>

            <div class="col-3">
                <a href="/dashboard/users/create" class="btn btn-dark btn-block w-100">
                    {{ lang('Create new user') }}
                </a>
            </div>

            <x-alert></x-alert>

            <div class="card mt-3">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ lang('ID') }}</th>
                                <th>{{ lang('Photo') }}</th>
                                <th>{{ lang('Name') }}</th>
                                <th>{{ lang('Email') }}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td><img class="img-profile-list" src="{{ $user->photo }}" alt="{{ $user->name }}"></td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>

                                    <td>
                                        <a class="text-decoration-none text-dark" href="{{ '/dashboard/users/edit/' . $user->id }}" title="{{ lang('Edit user') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a class="text-decoration-none text-danger" href="{{ '/dashboard/users/delete/' . $user->id }}" title="{{ lang('Delete user') }}">
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
</x-template-dashboard>
