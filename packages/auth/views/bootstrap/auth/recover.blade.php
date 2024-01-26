<x-template-auth>
    <div class="row">
        <div class="col-4 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form class="flex flex-col" method="POST" action="{{ '/recover/' . $id }}">
                        <input type="hidden" name="id" value="{{ $id }}">

                        <div class="mt-3 mb-3">
                            <x-label for="password" text="{{ lang('Password') }}"/>
                            <x-input name="password" required type="password"/>
                        </div>

                        <div class="mt-3 mb-3">
                            <x-label for="confirm_password" text="{{ lang('Confirm password') }}"/>
                            <x-input name="confirm_password" required type="password"/>
                        </div>

                        <x-button color="dark" border="dark">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            {{ lang('Restore password') }}
                        </x-button>
                    </form>                    
                </div>
            </div>
        </div>

    </div>
</x-template-auth>
