<x-template-auth>
    <x-alert/>

    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="/forgot-password">
                        <div>
                            <p class="text-justify">{{ lang('auth.text') }}</p>
                        </div>

                        <div class="mt-3 mb-5">
                            <x-label for="email" text="{{ lang('auth.email') }}"/>
                            <x-input name="email" required type="email"/>
                        </div>

                        <x-button color="dark" border="dark">
                            <i class="fas fa-link mr-2"></i>
                            {{ lang('auth.send_link') }}
                        </x-button>
                    </form>
                </div>
            </div>            
        </div>
    </div>

</x-template-auth>
