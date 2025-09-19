<li class="bg-gray-50 rounded-lg shadow transition transform hover:-translate-y-1 hover:shadow-lg hover:bg-blue-50 flex justify-between items-center p-5">
    <div>
        <a href="{{ route('activity.show', $activity['id']) }}" class="block">
            <span class="text-gray-800 font-semibold text-lg">{{ $activity['name'] }}</span>
            <div class="text-gray-600 text-sm mt-1">
                {{ \Illuminate\Support\Str::limit($activity['description'], 30) }}
            </div>
            <div class="text-gray-500 text-xs mt-1">
                Locatie: {{ $activity['location'] ?? 'Onbekend' }}
            </div>
        </a>
    </div>

    <div class="flex flex-col items-end">
        <div class="text-gray-700 text-sm mb-2">
            {{ \Carbon\Carbon::parse($activity['start_time'])->format('H:i') }} - {{ \Carbon\Carbon::parse($activity['end_time'])->format('H:i') }}
        </div>

        <!-- Afmelden button -->
        <form action="{{ route('enrolled.destroy', $activity['id']) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-4 py-1.5 bg-red-500 text-white rounded hover:bg-red-600 text-sm font-semibold">
                Afmelden
            </button>
        </form>
    </div>
</li>
