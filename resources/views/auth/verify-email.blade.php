<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Bedankt voor het registreren! Voordat je begint, kun je je e-mailadres verifiëren door op de link te klikken die we zojuist naar je hebben gemaild? Als je de e-mail niet hebt ontvangen, sturen we je graag een andere.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ __('Er is een nieuwe verificatielink verzonden naar het e-mailadres dat je tijdens de registratie hebt opgegeven.') }}
    </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Verzend verificatie e-mail') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Uit') }}
            </button>
        </form>
    </div>
</x-guest-layout>