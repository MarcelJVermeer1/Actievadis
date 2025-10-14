<x-guest-layout>
    <div class="mb-2 font-semibold text-sm text-gray-600">
        {{ __('Bedankt voor het registreren! We hebben je een mail verstuurd met een verificatielink, Je kan verder nadat je die hebt bevestigd.') }}
    </div>
    <p class="text-xs text-gray-500 text-opacity-70 mb-4">In het geval dat het niet gelukt is kan je op de knop klikken om de mail opnieuw te versturen.</p>

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