<x-template-dashboard active="users">
    <div>
        <form action="/dashboard/users/store" method="POST" enctype="multipart/form-data">
            <h1>{{ lang('Create new user') }}</h1>

            <hr>

            <x-alert/>

            <div class="row">
                <div class="col-5">
                    <h4>{{ lang('Profile info') }}</h4>
                    <h5>{{ lang('Add name and email.') }}</h5>
                </div>

                <div class="col-7">
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" id="photo-url" value="{{ asset('img/user.png') }}">

                            <x-label for="photo" text="{{ lang('Photo') }}"/>

                            <div>
                                <img id="photo-preview" class="img-photo mb-2" src="{{ asset('img/user.png') }}" alt="">
                            </div>

                            <div>
                                <x-file-button id="photo" class="btn btn-outline-secondary">
                                    <i class="fa fa-upload mr-2"></i>
                                    {{ lang('Select new photo') }}
                                </x-file-button>

                                <x-file-button show="photo != ''" click="removePhoto()" class="btn btn-danger">
                                    <i class="fa fa-trash mr-2"></i>
                                    {{ lang('Delete photo') }}
                                </x-file-button>

                                <div class="mt-3">
                                    <x-label for="name" text="{{ lang('Name') }}"/>
                                    <x-input name="name" value="{{ old('name') }}" required/>
                                </div>

                                <div class="mt-3">
                                    <x-label for="email" text="{{ lang('Email') }}"/>
                                    <x-input name="email" value="{{ old('email') }}" required type="email"/>
                                </div>
                            </div>                            
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <div class="w-full p-3">
        <form action="/dashboard/users/store" method="POST" enctype="multipart/form-data">
            <hr class="my-5">

            <div class="row">
                <div class="col-5">
                    <h4>{{ lang('Change password') }}</h4>
                    <h5>{{ lang('Make sure your account is using a long, random password to stay secure.') }}</h5>
                </div>

                <div class="col-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="mt-3">
                                <x-label for="password" text="{{ lang('Password') }}"/>
                                <x-input name="password" required type="password"/>
                            </div>

                            <div class="mt-3">
                                <x-label for="confirm_password" text="{{ lang('users.confirm_password') }}"/>
                                <x-input name="confirm_password" required type="password"/>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 mb-5 offset-5 col-7">
                <x-button color="dark" border="dark">
                    <i class="fa fa-save mr-2"></i>
                    {{ lang('Save') }}
                </x-button>
            </div>

            <x-input type="hidden" name="redirect" value="/dashboard/users/create"/>
        </form>
    </div>
</x-template-dashboard>
