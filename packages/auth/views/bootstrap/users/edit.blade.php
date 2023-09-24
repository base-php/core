<x-template-dashboard title="Editar usuario" active="users">
    <div>
        <div class="container mt-3">
            <h1>{{ lang('users.edit') }}</h1>

            <hr>

            <x-alert/>

            <div class="row mb-4">
                <div class="col-5 p-3">
                    <h5 class="mb-3">{{ lang('users.profile_info') }}</h5>
                    <h6>{{ lang('users.edit_name_email') }}</h6>
                </div>

                <input type="hidden" id="photo-url" value="{{ $user->photo }}">

                <div class="col-7 p-4 rounded bg-white">
                    <form action="/dashboard/users/update" method="POST">
                        <x-input type="hidden" name="id" value="{{ $user->id }}"/>

                        <div>
                            <div>
                                <label for="photo">Foto</label>
                                <input class="d-none" x-model="photo" id="photo" type="file" name="photo">

                                <div>
                                    <img id="photo-preview" class="mb-2 img-photo" src="{{ $user->photo }}" alt="{{ $user->name }}">
                                </div>

                                <div>
                                    <x-file-button id="open-file-selector" background="white" text="black" border="dark">
                                        <i class="fa fa-upload mr-2"></i>
                                        {{ lang('users.select_photo') }}
                                    </x-file-button>

                                    <x-file-button background="danger" text="white" border="danger">
                                        <i class="fa fa-trash mr-2"></i>
                                        {{ lang('users.delete_photo') }}
                                    </x-file-button>
                                </div>
                            </div>

                            <div class="mt-3">
                                <x-label for="name" text="{{ lang('users.name') }}"/>
                                <x-input name="name" value="{{ $user->name }}" required/>
                            </div>

                            <div class="mt-3">
                                <x-label for="email" text="{{ lang('users.email') }}"/>
                                <x-input name="email" value="{{ $user->email }}" required type="email"/>
                            </div>

                            <div class="mt-3">
                                <x-button background="black" color="dark" text="white" border="dark">
                                    <i class="fa fa-save mr-2"></i>
                                    {{ lang('users.save') }}
                                </x-button>
                            </div>

                            <input type="hidden" name="password" value="">
                            <input type="hidden" name="confirm_password" value="">
                        </div>                        
                    </form>
                </div>
            </div>

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col-5 p-3">
                    <h5 class="mb-3">{{ lang('users.change_password') }}</h5>
                    <h6>{{ lang('users.change_password_text') }}</h6>
                </div>

                <div class="col-7 p-4 rounded bg-white">
                    <form action="/dashboard/users/update" method="POST" enctype="multipart/form-data">
                        <x-input type="hidden" name="id" value="{{ $user->id }}"/>

                        <div>
                            <div class="mt-3">
                                <x-label for="password" text="{{ lang('users.password') }}"/>
                                <x-input name="password" type="password" required/>
                            </div>

                            <div class="mt-3">
                                <x-label for="confirm_password" text="{{ lang('users.confirm_password') }}"/>
                                <x-input name="confirm_password" type="password" required/>
                            </div>

                            <div class="mt-3">
                                <x-button background="black" color="dark" text="white" border="dark">
                                    <i class="fa fa-save mr-2"></i>
                                    {{ lang('users.save') }}
                                </x-button>
                            </div>

                            <input type="hidden" name="name" value="{{ $user->name }}">
                            <input type="hidden" name="email" value="{{ $user->email }}">
                        </div>                        
                    </form>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-5 p-3">
                    <h5 class="mb-3">{{ lang('users.sessions') }}</h5>
                    <h6>{{ lang('users.sessions_text') }}</h6>
                </div>

                <div class="col-7 p-4 rounded bg-white">
                    <div>
                        <p>{{ lang('users.sessions_description') }}</p>
                    </div>

                    <div class="mt-5">
                        @foreach(json($user->sessions ?? '[]') as $session)
                            <div>
                                <i class="fa-solid fa-desktop"></i>
                                <small>{{ $session['device'] }} - {{ $session['ip'] }} - {{ $session['datetime'] }}</small>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5">
                        <x-button-link href="{{ '/logoutInOthersDevices/' . $user->id }}" color="black">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i>
                            {{ lang('users.logout_other_browsers') }}
                        </x-button-link>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col-5 p-3">
                    <h5 class="mb-3">{{ lang('users.delete_account') }}</h5>
                    <h6>{{ lang('users.delete_account_permanently') }}</h6>
                </div>

                <div class="col-7 p-4 rounded bg-white">
                    <div>
                        <p>{{ lang('users.delete_account_text') }}</p>
                    </div>

                    <div>
                        <x-button-link click="confirmDelete(event, $el)" href="{{ '/dashboard/users/delete/' . $user->id }}" color="danger">
                            <i class="fa fa-trash mr-2"></i>
                            {{ lang('users.delete_account') }}
                        </x-button-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-template-dashboard>
