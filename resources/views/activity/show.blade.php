<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activiteiten') }}
        </h2>
    </x-slot>

    <div class="my-10 min-h-[40vh] w-4/6 mx-auto bg-blue-950 text-white rounded-lg shadow-lg p-10 space-y-6">

        {{-- Afbeelding --}}
        @if($activity->image_base64)
            <img src="data:image/png;base64,{{ $activity->image_base64 }}"
                 alt="Afbeelding van {{ $activity->name }}"
                 class="w-full max-h-96 object-cover rounded-lg shadow-md mb-6">
        @endif

        <h1 class="text-5xl font-bold text-center">{{ $activity->name }}</h1>

        <p class="text-lg text-orange-400">Omschrijving</p>
        <p class="text-lg">{{ $activity->description }}</p>

        <p class="text-lg text-orange-400">Kosten: €{{ number_format($activity->costs, 2) }}</p>
        <p class="text-lg text-orange-400">Inclusief eten: {{ $activity->food ? 'Ja' : 'Nee' }}</p>

        <p class="text-lg text-orange-400">Locatie: {{ $activity->location }}</p>

        <p class="text-lg text-orange-400">
            Begin tijd: {{ \Carbon\Carbon::parse($activity->starttime)->format('d-m-Y H:i') }} <br>
            Eind tijd: {{ \Carbon\Carbon::parse($activity->endtime)->format('d-m-Y H:i') }}
        </p>

        {{-- Capaciteit --}}
        @if($activity->max_participants)
            @if($isFull)
                <p class="text-red-500 font-bold">Vol - aanmelden niet meer mogelijk</p>
            @else
                <p class="text-green-400">Nog {{ $remaining }} plekken beschikbaar</p>
            @endif
        @endif

        {{-- Inschrijven (user) --}}
        @auth
            <div class="flex justify-center gap-6 pt-6">
                <form method="POST" action="{{ route('activity.enroll', $activity->id) }}">
                    @csrf
                    <input type="hidden" name="status" value="attending">
                    <button type="submit" class="px-8 py-3 border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white rounded-lg font-semibold text-lg" 
                            @if($isFull) disabled @endif>
                        Aanwezig
                    </button>
                </form>

                <form method="POST" action="{{ route('activity.enroll', $activity->id) }}">
                    @csrf
                    <input type="hidden" name="status" value="maybe">
                    <button type="submit" class="px-8 py-3 border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white rounded-lg font-semibold text-lg">
                        Misschien
                    </button>
                </form>
            </div>
        @endauth

        {{-- Gast formulier --}}
        <div class="mt-8">
            <h3 class="text-xl font-bold text-orange-400 mb-2">Gast inschrijven</h3>
            <form method="POST" action="{{ route('activity.guest.enroll', $activity->id) }}" class="space-y-4">
                @csrf
                <input type="text" name="name" placeholder="Naam" required class="w-full rounded-md text-black px-3 py-2">
                <input type="email" name="email" placeholder="E-mail" required class="w-full rounded-md text-black px-3 py-2">
                <input type="text" name="phone" placeholder="Telefoonnummer" class="w-full rounded-md text-black px-3 py-2">

                <select name="status" class="w-full rounded-md text-black px-3 py-2">
                    <option value="attending">Aanwezig</option>
                    <option value="maybe">Misschien</option>
                </select>

                <button type="submit" class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg">Inschrijven</button>
            </form>
        </div>

        {{-- Lijsten deelnemers --}}
        <div class="mt-10">
            <h3 class="text-2xl font-bold text-orange-400">Aanwezigen (Users)</h3>
            <ul class="list-disc ml-6">
                @forelse($userAttendees as $u)
                    <li>{{ $u->name }}</li>
                @empty
                    <li>Geen gebruikers aanwezig</li>
                @endforelse
            </ul>

            <h3 class="text-2xl font-bold text-orange-400 mt-6">Aanwezigen (Gasten)</h3>
            <ul class="list-disc ml-6">
                @forelse($guestAttendees as $g)
                    <li>{{ $g->name }} ({{ $g->email }})</li>
                @empty
                    <li>Geen gasten aanwezig</li>
                @endforelse
            </ul>

            <h3 class="text-2xl font-bold text-orange-400 mt-6">Misschien (Users)</h3>
            <ul class="list-disc ml-6">
                @forelse($userMaybes as $u)
                    <li>{{ $u->name }}</li>
                @empty
                    <li>Geen gebruikers</li>
                @endforelse
            </ul>

            <h3 class="text-2xl font-bold text-orange-400 mt-6">Misschien (Gasten)</h3>
            <ul class="list-disc ml-6">
                @forelse($guestMaybes as $g)
                    <li>{{ $g->name }} ({{ $g->email }})</li>
                @empty
                    <li>Geen gasten</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
