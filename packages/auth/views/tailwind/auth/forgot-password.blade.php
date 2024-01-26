<x-template-auth>
    <x-alert/>

    <div>
        <form class="flex flex-col" method="POST" action="/forgot-password">
            <div>
                <p class="text-justify">{{ lang('Did you forget your password? No problem. Click on the following link to reset your password.') }}</p>
            </div>

            <div class="mt-3 mb-5">
                <x-label for="email" text="{{ lang('Email') }}"/>
                <x-input name="email" required type="email"/>
            </div>

            <x-button color="black">
                <i class="fas fa-link mr-2"></i>
                {{ lang('Send link') }}
            </x-button>
        </form>
    </div>
</x-template-auth>
