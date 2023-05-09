<x-template-dashboard active="users">
    <div>
        <h1>{{ lang('users.users') }}</h1>

        <div class="row">
            <div class="col-9">
                <input type="text" type="text" autofocus class="form-control" placeholder="{{ lang('users.search') }}">
            </div>

            <div class="col-3">
                <a href="/dashboard/users/create" class="btn btn-dark btn-block">
                    {{ lang('users.create') }}
                </a>
            </div>

            <x-alert></x-alert>

            <div class="card mt-3">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ lang('users.id') }}</th>
                                <th>{{ lang('users.photo') }}</th>
                                <th>{{ lang('users.name') }}</th>
                                <th>{{ lang('users.email') }}</th>
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
                                        <a class="text-decoration-none text-dark" href="{{ '/dashboard/users/edit/' . $user->id }}" title="{{ lang('users.edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a class="text-decoration-none text-danger" href="{{ '/dashboard/users/delete/' . $user->id }}" title="{{ lang('users.delete') }}">
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
