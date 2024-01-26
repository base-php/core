<x-template-auth>
    <div class="row">
        <div class="col-4 mx-auto">
            <x-alert/>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="/register">
                        <div>
                            <x-label for="name" text="{{ lang('Name') }}"/>
                            <x-input name="name" required/>
                        </div>

                        <div class="mt-3">
                            <x-label for="email" text="{{ lang('Email') }}"/>
                            <x-input name="email" required type="email"/>
                        </div>

                        <div class="mt-3">
                            <x-label for="password" text="{{ lang('Password') }}"/>
                            <x-input name="password" required type="password"/>
                        </div>

                        <div class="mt-3 mb-3">
                            <x-label for="confirm_password" text="{{ lang('Confirm password') }}"/>
                            <x-input name="confirm_password" required type="password"/>
                        </div>

                        <div class="text-center">
                            <x-button color="dark">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                {{ lang('Register') }}
                            </x-button>

                            @if(config('facebook'))
                                <x-social-button url="{{ facebook()->url() }}" color="primary">
                                    <i class="fab fa-facebook mr-2"></i>
                                    {{ lang('Login') }}
                                </x-social-button>
                            @endif

                            @if(config('google'))
                                <x-social-button url="{{ google()->url() }}" color="danger">
                                    <i class="fab fa-google mr-2"></i>
                                    {{ lang('Login') }}
                                </x-social-button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-template-auth>
