<x-template-dashboard active="users">
    <div>
        <form action="/dashboard/users/store" method="POST" enctype="multipart/form-data">
            <h1>{{ lang('users.create') }}</h1>

            <hr>

            <x-alert/>

            <div class="row">
                <div class="col-5">
                    <h4>{{ lang('users.profile_info') }}</h4>
                    <h5>{{ lang('users.add_name_email') }}</h5>
                </div>

                <div class="col-7">
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" id="photo-url" value="{{ asset('img/user.png') }}">

                            <x-label for="photo" text="{{ lang('users.photo') }}"/>

                            <div>
                                <img id="photo-preview" class="img-photo mb-2" src="{{ asset('img/user.png') }}" alt="">
                            </div>

                            <div>
                                <x-file-button show="photo == ''" click="document.getElementById('photo').click()" id="open-file-selector" border="dark" background="white" text="black">
                                    <i class="fa fa-upload mr-2"></i>
                                    {{ lang('users.select_photo') }}
                                </x-file-button>

                                <x-file-button show="photo != ''" click="removePhoto()" background="danger" border="danger" text="white">
                                    <i class="fa fa-trash mr-2"></i>
                                    {{ lang('users.delete_photo') }}
                                </x-file-button>

                                <div class="mt-3">
                                    <x-label for="name" text="{{ lang('users.name') }}"/>
                                    <x-input name="name" value="{{ old('name') }}" required/>
                                </div>

                                <div class="mt-3">
                                    <x-label for="email" text="{{ lang('users.email') }}"/>
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
                    <h4>{{ lang('users.change_password') }}</h4>
                    <h5>{{ lang('users.change_password_text') }}</h5>
                </div>

                <div class="col-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="mt-3">
                                <x-label for="password" text="{{ lang('users.password') }}"/>
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
                    {{ lang('users.save') }}
                </x-button>
            </div>

            <x-input type="hidden" name="redirect" value="/dashboard/users/create"/>
        </form>
    </div>
</x-template-dashboard>
