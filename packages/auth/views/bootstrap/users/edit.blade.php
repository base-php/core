<x-template-dashboard title="Editar usuario" active="users">
    <div>
        <div class="container mt-3">
            <h1>{{ lang('Edit user') }}</h1>

            <hr>

            <x-alert/>

            <div class="row mb-4">
                <div class="col-5 p-3">
                    <h5 class="mb-3">{{ lang('Profile info') }}</h5>
                    <h6>{{ lang('Update name and email.') }}</h6>
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
                                        {{ lang('Select new photo') }}
                                    </x-file-button>

                                    <x-file-button background="danger" text="white" border="danger">
                                        <i class="fa fa-trash mr-2"></i>
                                        {{ lang('Delete photo') }}
                                    </x-file-button>
                                </div>
                            </div>

                            <div class="mt-3">
                                <x-label for="name" text="{{ lang('Name') }}"/>
                                <x-input name="name" value="{{ $user->name }}" required/>
                            </div>

                            <div class="mt-3">
                                <x-label for="email" text="{{ lang('Email') }}"/>
                                <x-input name="email" value="{{ $user->email }}" required type="email"/>
                            </div>

                            <div class="mt-3">
                                <x-button background="black" color="dark" text="white" border="dark">
                                    <i class="fa fa-save mr-2"></i>
                                    {{ lang('Save') }}
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
                    <h5 class="mb-3">{{ lang('Change password') }}</h5>
                    <h6>{{ lang('Make sure your account is using a long, random password to stay secure.') }}</h6>
                </div>

                <div class="col-7 p-4 rounded bg-white">
                    <form action="/dashboard/users/update" method="POST" enctype="multipart/form-data">
                        <x-input type="hidden" name="id" value="{{ $user->id }}"/>

                        <div>
                            <div class="mt-3">
                                <x-label for="password" text="{{ lang('Password') }}"/>
                                <x-input name="password" type="password" required/>
                            </div>

                            <div class="mt-3">
                                <x-label for="confirm_password" text="{{ lang('Confirm Password') }}"/>
                                <x-input name="confirm_password" type="password" required/>
                            </div>

                            <div class="mt-3">
                                <x-button background="black" color="dark" text="white" border="dark">
                                    <i class="fa fa-save mr-2"></i>
                                    {{ lang('Save') }}
                                </x-button>
                            </div>

                            <input type="hidden" name="name" value="{{ $user->name }}">
                            <input type="hidden" name="email" value="{{ $user->email }}">
                        </div>                        
                    </form>
                </div>
            </div>

            @if(class_exists('PragmaRX\Google2FA\Google2FA') && class_exists('Endroid\QrCode\QrCode'))
                <hr>

                <div class="row">
                    <div class="col-5 p-3">
                        <h1 class="mb-3">{{ lang('Two-factor authentication') }}</h1>
                        <h2>{{ lang('Add additional security to your account with two-factor authentication') }}</h2>
                    </div>

                    <input type="hidden" name="2fa" value="1">

                    @if($user->two_fa)
                        <div class="col-7 p-4 rounded bg-white">
                            <div>
                                <h1 class="mb-3">{{ lang('You have enabled two-factor authentication') }}</h1>

                                <p>{{ lang('Enable') }}</p>

                                <div>{!! two_fa()->qr($user->two_fa) !!}</div>

                                <p>{{ two_fa()->key() }}</p>

                                <div class="mt-5">
                                    <x-button-link href="{{ '/2fa/' . $user->id }}" color="red-500">
                                        <i class="fa fa-times mr-2"></i>
                                        {{ lang('Disable') }}
                                    </x-button-link>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-7 rounded bg-white p-4">
                            <div>
                                <h1 class="mb-3">{{ lang('You have not enabled two-factor authentication') }}</h1>

                                <p>{{ lang('When two-factor authentication is enabled, you will be prompted for a random, secure token during authentication. You can retrieve this token from the Google Authenticator app on your phone.') }}</p>
                            </div>

                            <div class="mt-5">
                                <x-button-link href="{{ '/2fa/' . $user->id }}" color="black">
                                    <i class="fa fa-check mr-2"></i>
                                    {{ lang('users.2fa_enable') }}
                                </x-button-link>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <hr>

            <div class="row">
                <div class="col-5 p-3">
                    <h5 class="mb-3">{{ lang('Sessions') }}</h5>
                    <h6>{{ lang('Manage and log out of your active sessions on other browsers and devices.') }}</h6>
                </div>

                <div class="col-7 p-4 rounded bg-white">
                    <div>
                        <p>{{ lang('If necessary, you can log out of all your devices. Some of their recent sessions are listed below; however, this list may not be exhausted. If you believe your account has been compromised, you should also update your password.') }}</p>
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
                            {{ lang('Sign out of other browsers') }}
                        </x-button-link>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col-5 p-3">
                    <h5 class="mb-3">{{ lang('Delete account') }}</h5>
                    <h6>{{ lang('Delete your account permanently.') }}</h6>
                </div>

                <div class="col-7 p-4 rounded bg-white">
                    <div>
                        <p>{{ lang('Once your account is deleted, all your resources and data will be permanently deleted. Before deleting your account, download any data or information you want to keep.') }}</p>
                    </div>

                    <div>
                        <x-button-link click="confirmDelete(event, $el)" href="{{ '/dashboard/users/delete/' . $user->id }}" color="danger">
                            <i class="fa fa-trash mr-2"></i>
                            {{ lang('Delete account') }}
                        </x-button-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-template-dashboard>
