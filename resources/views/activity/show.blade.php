<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Activiteiten') }}
        </h2>
    </x-slot>

    <div
        class="w-4/6 mx-auto my-8 bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden flex flex-col lg:flex-row">
        <!-- Image Section -->
        @if($activity->image)
            <div class="lg:w-1/3 w-full h-64 lg:h-auto overflow-hidden">
                <img src="{{ $activity->image_src }}" alt="{{ $activity->name }}" class="w-full h-full object-contain">
            </div>
        @endif

        <!-- Content Section -->
        <div class="lg:w-2/3 w-full p-6 flex flex-col justify-between">
            <!-- Title -->
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-black mb-1">{{ $activity->name }}</h1>
                <p class="text-gray-500 text-xs">Gepubliceerd op {{ $activity->created_at->format('d M Y') }}</p>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <h2 class="text-xs font-semibold text-amber-500 uppercase mb-1">Omschrijving</h2>
                <p class="text-gray-700 text-sm leading-relaxed">{{ $activity->description }}</p>
            </div>

            <!-- Details Grid -->
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                @php
                    $details = [
                        ['label' => 'Locatie', 'value' => $activity->location],
                        ['label' => 'Kosten', 'value' => '€' . number_format($activity->costs, 2)],
                        ['label' => 'Inclusief eten', 'value' => $activity->food ? 'Ja' : 'Nee'],
                        ['label' => 'Starttijd', 'value' => \Carbon\Carbon::parse($activity->starttime)->format('d-m-Y H:i')],
                        ['label' => 'Eindtijd', 'value' => \Carbon\Carbon::parse($activity->endtime)->format('d-m-Y H:i')],
                        ['label' => 'Capaciteit', 'value' => $amountOfEnrollments . '/' . $activity->max_capacity . ' deelnemers'],
                    ];
                @endphp

                @foreach($details as $detail)
                    <div>
                        <h3 class="text-xs font-semibold text-amber-500 uppercase mb-0.5">{{ $detail['label'] }}</h3>
                        <p class="text-gray-800 text-sm">{{ $detail['value'] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3 mt-auto">
                @php
                    $userIsEnrolled = $activity->users->contains('id', Auth::id());
                @endphp

                @if($userIsEnrolled)
                    <a href="{{ route('enrolled.destroy', $activity->id) }}"
                        class="px-5 py-2 bg-black text-white rounded-md hover:bg-gray-800 transition font-medium shadow-sm">
                        Afmelden
                    </a>
                @elseif($activity->max_capacity <= $amountOfEnrollments)
                    <span class="px-5 py-2 bg-gray-200 text-gray-500 rounded-md font-medium shadow-inner">
                        Vol
                    </span>
                @else
                    <a href="{{ route('activity.enroll', $activity->id) }}"
                        class="px-5 py-2 border border-amber-500 text-amber-500 rounded-md hover:bg-amber-500 hover:text-white transition font-medium shadow-sm">
                        Aanmelden
                    </a>
                @endif
            </div>

        </div>
        @if(Auth::user() && Auth::user()->is_admin)
            <div class="mb-6 mr-4 self-end flex gap-3">
                <a href="{{ route('activities.edit', $activity->id) }}"
                    class="px-5 py-2 border border-amber-500 text-amber-500 rounded-md hover:bg-amber-500 hover:text-white transition font-medium shadow-sm">
                    Bewerken
                </a>
                <form action="{{ route('activity.destroy', $activity->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-5 py-2 border border-amber-500 text-amber-500 rounded-md hover:bg-amber-500 hover:text-white transition font-medium shadow-sm">
                        Verwijderen
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Enrolled List (unchanged) -->
    @if($canViewEnrollments)
        <div class="mt-8 w-4/6 mx-auto bg-white text-blue-950 rounded-lg shadow-lg p-4">
            <h3 class="text-xl font-bold mb-3">
                Aanmeldingen {{ $amountOfEnrollments }}/{{ $activity->max_capacity }}
            </h3>

            @if($paginator->count())
                <ul class="mb-4 divide-y divide-gray-200">
                    @foreach ($paginator as $participant)
                        <li class="py-2 flex justify-between items-center">
                            <div>
                                <span class="font-semibold">{{ $participant->name }}</span><br>
                                <span class="text-gray-500 text-xs">{{ $participant->email }}</span>
                            </div>

                            <span
                                class="text-xs uppercase px-2 py-1 rounded-full 
                                                                                                                                                                                                               {{ $participant->type === 'Gast' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $participant->type }}
                            </span>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-4 flex justify-center">
                    {{ $paginator->withQueryString()->links('pagination.tailwind-nl') }}
                </div>
            @else
                <p class="py-2 text-gray-600 text-sm">Nog geen deelnemers.</p>
            @endif
        </div>
    @else
        <p class="py-2 text-gray-600 text-center text-sm">
            Je hebt geen toegang om de deelnemerslijst te bekijken.
        </p>
    @endif
</x-app-layout>