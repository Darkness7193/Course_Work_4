<!-- imports: -->
    @vite(['resources/css/breeze-base.css'])


<x-guest-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        {{ __('Эта область сайта имеет огранченный доступ. Подтвердите пароль прежде чем продолжить.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Пароль')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Подтвердить') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
