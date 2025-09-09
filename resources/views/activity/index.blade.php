<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6 mt-8">
            <h2 class="text-2xl font-bold mb-4">Activiteiten:</h2>
            <ul class="grid grid-cols-1  gap-6 cursor-pointer">
                @forelse($activities as $activity)
                    <li class="bg-gray-50 rounded-lg shadow p-5 flex flex-col sm:flex-row sm:items-center justify-between transition transform hover:-translate-y-1 hover:shadow-lg hover:bg-blue-50">
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
                    </li>
                @empty
                    <li class="py-3 text-gray-500">Geen activiteiten gevonden.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>