@forelse($activities as $activity)
    <li class="bg-gray-50 rounded-lg shadow transition transform hover:-translate-y-1 hover:shadow-lg hover:bg-blue-50 flex justify-between items-center"
        onclick="window.location='{{ route('activity.show', $activity['id']) }}'">
            <a class="block p-5 flex flex-col sm:flex-row sm:items-center justify-between">

                <div>
                    <span class="text-gray-800 font-semibold text-lg">{{ $activity['name'] }}</span>
                    <div class="text-gray-600 text-sm mt-1">
                        {{ \Illuminate\Support\Str::limit($activity['description'], 30) }}
                    </div>
                    <div class="text-gray-500 text-xs mt-1">
                        Locatie: {{ $activity['location'] ?? 'Onbekend' }}
                    </div>


                    {{-- ✅ Minimaal aantal deelnemers --}}
                    @php
                        $min = $activity->min ?? 0;
                        $max = $activity->max_capacity ?? 0;
                        $enrolled = $activity->enrolled_count ?? 0;
                        $neededForMin = max($min - $enrolled, 0);
                        $available = max($max - $enrolled, 0);
                    @endphp

                    <div class="text-xs mt-1
                                            @if ($neededForMin > 0)
                                                text-red-600
                                            @else
                                                text-green-600
                                            @endif">
                        Minimaal nodig: {{ $min }}
                        @if ($neededForMin > 0)
                            (nog {{ $neededForMin }} nodig)
                        @else
                            ✅ Minimaal bereikt
                        @endif
                    </div>

                    {{-- ✅ Beschikbare plekken --}}
                    <div class="text-xs mt-1
                                            @if ($available > 0)
                                                text-gray-500
                                            @else
                                                text-red-600 font-semibold
                                            @endif">
                        Beschikbare plekken:
                        @if ($available > 0)
                            {{ $available }}
                        @else
                            ❌ Vol
                        @endif
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


                        @php
                            $amountOfEnrollments = $activity->guestUsers->count() + $activity->users->count();
                            $isFull = $activity->max_capacity <= $amountOfEnrollments;
                        @endphp

                        @if ($role == "activity")
                            @if ($isFull)
                                <a class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed opacity-70">
                                    Vol
                                </a>
                            @else
                                <a href="{{ route('activity.enroll', $activity->id) }}"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                    Aanmelden
                                </a>
                            @endif
                        @elseif($role == "enrolled")
                            <a href="{{ route('enrolled.destroy', $activity->id) }}"
                                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                                Afmelden
                            </a>
                        @else

                        @endif
                    </div>

            </a>
    </li>
@empty
    <li class="py-3 text-gray-500">Geen activiteiten gevonden.</li>
@endforelse