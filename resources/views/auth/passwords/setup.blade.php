<x-guest-layout>
    <!-- Formulario de configuración de contraseña -->
    <form method="POST" action="{{ route('password.setup.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email Address -->
        <input id="email" type="hidden" name="email" value="{{ $email }}" />

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Configurar contraseña') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
