<x-template-dashboard title="Editar usuario" active="users">
    <div x-init="$watch('photo', value => preview(value))">
        <div class="w-full p-3">
            <h1 class="text-4xl">{{ lang('Edit user') }}</h1>

            <hr class="my-5">

            <x-alert/>

            <div class="flex">
                <div class="w-5/12 p-3">
                    <h1 class="font-semibold text-2xl mb-3">{{ lang('Profile info') }}</h1>
                    <h2>{{ lang('Update name and email.') }}</h2>
                </div>

                <input type="hidden" id="photo-url" value="{{ $user->photo }}">

                <div class="w-7/12 rounded bg-white p-7">
                    <form action="/dashboard/users/update" method="POST" enctype="multipart/form-data">
                        <x-input type="hidden" name="id" value="{{ $user->id }}"/>

                        <div>
                            <label for="photo">Foto</label>
                            <input class="hidden" x-model="photo" id="photo" type="file" name="photo">
                            <img id="photo-preview" class="rounded-full mb-2 block w-1/4" src="{{ $user->photo }}" alt="{{ $user->name }}">

                            <div>
                                <x-file-button show="photo == ''" click="document.getElementById('photo').click()" id="open-file-selector" border="black" background="white" text="black">
                                    <i class="fa fa-upload mr-2"></i>
                                    {{ lang('Select new photo') }}
                                </x-file-button>

                                <x-file-button show="photo != ''" click="removePhoto()" background="red-500" text="white" border="red-500">
                                    <i class="fa fa-trash mr-2"></i>
                                    {{ lang('Delete photo') }}
                                </x-file-button>
                            </div>
                        </div>

                        <div class="mt-5">
                            <x-label for="name" text="{{ lang('Name') }}"/>
                            <x-input name="name" value="{{ $user->name }}" required/>
                        </div>

                        <div class="mt-5">
                            <x-label for="email" text="{{ lang('Email') }}"/>
                            <x-input name="email" value="{{ $user->email }}" required type="email"/>
                        </div>

                        <div class="mt-5">
                            <x-button color="black">
                                <i class="fa fa-save mr-2"></i>
                                {{ lang('Save') }}
                            </x-button>
                        </div>

                        <input type="hidden" name="password" value="">
                        <input type="hidden" name="confirm_password" value="">
                    </form>
                </div>
            </div>

            <hr class="my-5">

            <div class="flex">
                <div class="w-5/12 p-3">
                    <h1 class="font-semibold text-2xl mb-3">{{ lang('Change password') }}</h1>
                    <h2>{{ lang('Make sure your account is using a long, random password to stay secure.') }}</h2>
                </div>

                <div class="w-7/12 rounded bg-white p-7">
                    <form action="/dashboard/users/update" method="POST">
                        <x-input type="hidden" name="id" value="{{ $user->id }}"/>

                        <div class="mt-5">
                            <x-label for="password" text="{{ lang('Password') }}"/>
                            <x-input name="password" type="password" required/>
                        </div>

                        <div class="mt-5">
                            <x-label for="confirm_password" text="{{ lang('Confirm Password') }}"/>
                            <x-input name="confirm_password" type="password" required/>
                        </div>

                        <div class="mt-5">
                            <x-button color="black">
                                <i class="fa fa-save mr-2"></i>
                                {{ lang('Save') }}
                            </x-button>
                        </div>

                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                    </form>
                </div>
            </div>

            @if(class_exists('PragmaRX\Google2FA\Google2FA') && class_exists('Endroid\QrCode\QrCode'))
                <hr class="my-5">

                <div class="flex">
                    <div class="w-5/12 p-3">
                        <h1 class="font-semibold text-2xl mb-3">{{ lang('Two-factor authentication') }}</h1>
                        <h2>{{ lang('Add additional security to your account with two-factor authentication') }}</h2>
                    </div>

                    <input type="hidden" name="2fa" value="1">

                    @if($user->two_fa)
                        <div class="w-7/12 rounded bg-white p-7">
                            <div>
                                <h1 class="font-semibold text-2xl mb-3">{{ lang('You have enabled two-factor authentication') }}</h1>

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
                        <div class="w-7/12 rounded bg-white p-7">
                            <div>
                                <h1 class="font-semibold text-2xl mb-3">{{ lang('You have not enabled two-factor authentication') }}</h1>

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

            <hr class="my-5">

            <div class="flex">
                <div class="w-5/12 p-3">
                    <h1 class="font-semibold text-2xl mb-3">{{ lang('Sessions') }}</h1>
                    <h2>{{ lang('Manage and log out of your active sessions on other browsers and devices.') }}</h2>
                </div>

                <div class="w-7/12 rounded bg-white p-7">
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

            <hr class="my-5">

            <div class="flex">
                <div class="w-5/12 p-3">
                    <h1 class="font-semibold text-2xl mb-3">{{ lang('Delete account') }}</h1>
                    <h2>{{ lang('Delete your account permanently.') }}</h2>
                </div>

                <div class="w-7/12 rounded bg-white p-7">
                    <div>
                        <p>{{ lang('Once your account is deleted, all your resources and data will be permanently deleted. Before deleting your account, download any data or information you want to keep.') }}</p>
                    </div>

                    <div class="mt-5">
                        <x-button-link click="confirmDelete(event, $el)" href="{{ '/dashboard/users/delete/' . $user->id }}" color="red-500">
                            <i class="fa fa-trash mr-2"></i>
                            {{ lang('Delete account') }}
                        </x-button-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-template-dashboard>
