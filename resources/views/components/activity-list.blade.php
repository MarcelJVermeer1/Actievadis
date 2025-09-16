@forelse($activities as $activity)
    <li class="bg-gray-50 rounded-lg shadow transition transform hover:-translate-y-1 hover:shadow-lg hover:bg-blue-50">
        <a href="{{ route('activity.show', $activity['id']) }}"  class="block p-5 flex flex-col sm:flex-row sm:items-center justify-between">
            <div>
                <span class="text-gray-800 font-semibold text-lg">{{ $activity['name'] }}</span>
                <div class="text-gray-600 text-sm mt-1">
                    {{ \Illuminate\Support\Str::limit($activity['description'], 30) }}
                </div>
                <div class="text-gray-500 text-xs mt-1">
                    Locatie: {{ $activity['location'] ?? 'Onbekend' }}
                </div>
            </div>
            <div class="text-gray-700 text-sm mt-2 sm:mt-0 sm:ml-6">
                {{ \Carbon\Carbon::parse($activity['start_time'])->format('H:i') }} - {{ \Carbon\Carbon::parse($activity['end_time'])->format('H:i') }}
            </div>
        </a>
    </li>
@empty
    <li class="py-3 text-gray-500">Geen activiteiten gevonden.</li>
@endforelse
