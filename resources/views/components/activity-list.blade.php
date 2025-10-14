@forelse($activities as $activity)
    <li
        class="bg-gray-50 rounded-lg shadow transition transform hover:-translate-y-1 hover:shadow-lg hover:bg-blue-50 flex justify-between items-center"
        onclick="window.location='{{ route('activity.show', $activity['id']) }}'">
        <a 
            class="block p-5 flex flex-col sm:flex-row sm:items-center justify-between">

            <div>
                <span class="text-gray-800 font-semibold text-lg">{{ $activity['name'] }}</span>
                <div class="text-gray-600 text-sm mt-1">
                    {{ \Illuminate\Support\Str::limit($activity['description'], 30) }}
                </div>
                <div class="text-gray-500 text-xs mt-1">
                    Locatie: {{ $activity['location'] ?? 'Onbekend' }}
                </div>

            </div>
            <div>
                <div class="flex items-center gap-5 mr-5 -mt-10">
                    <div>
                        @php
                            $startDate = \Carbon\Carbon::parse($activity['starttime']);
                            $endDate = \Carbon\Carbon::parse($activity['endtime']);
                        @endphp
                        <div class="text-gray-500 text-xs mt-1">
                            @if ($startDate->isSameDay($endDate))
                                📅 Datum: {{ $startDate->translatedFormat('d F Y') }}
                            @else
                                📅 Periode: {{ $startDate->translatedFormat('d F Y') }} t/m
                                {{ $endDate->translatedFormat('d F Y') }}
                            @endif
                        </div>
                        <div class=" text-gray-700 text-sm mt-2 sm:mt-3 sm:ml-6 grid grid-cols-2 gap-4">
                            <div cl>
                                Begintijd:
                                {{ \Carbon\Carbon::parse($activity['starttime'])->format('H:i') }}
                            </div>
                            <div>
                                Eindtijd:
                                {{ \Carbon\Carbon::parse($activity['endtime'])->format('H:i') }}
                            </div>
                        </div>
                    </div>


                    @if ($role == "activity")
                        <a href="{{ route('activity.enroll', $activity->id) }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            Aanmelden
                        </a>
                    @elseif($role == "enrolled")
                        <a href="{{ route('enrolled.destroy', $activity->id) }}"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                            Afmelden
                        </a>
                    @endif
                </div>

        </a>
    </li>
@empty
    <li class="py-3 text-gray-500">Geen activiteiten gevonden.</li>
@endforelse