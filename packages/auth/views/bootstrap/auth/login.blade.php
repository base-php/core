<x-template-auth>
    <div class="row">
        <div class="col-4 mx-auto">
            <x-alert/>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="/login">
                        <div>
                            <x-label for="email" text="{{ lang('Email') }}"/>
                            <x-input name="email" required type="email"/>
                        </div>

                        <div class="mt-3">
                            <label for="password">{{ lang('Password') }}</label>
                            <x-input name="password" required type="password"/>
                        </div>

                        @if(request('redirect'))
                            <x-input name="redirect" required type="hidden" value="{{ request('redirect') }}"/>
                        @endif

                        <div class="text-center p-3">
                            <a href="/forgot-password" class="text-sm text-black hover:text-black hover:underline mb-6">{{ lang('Did you forget your password?') }}</a>
                        </div>

                        <div class="text-center">
                            <x-button color="dark">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                {{ lang('Login') }}
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
