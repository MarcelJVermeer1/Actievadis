@props(['activity', 'role' => 'activity'])

<li onclick="window.location='{{ route('activity.show', $activity->id) }}'"
    class="bg-gray-50 rounded-lg shadow transition hover:-translate-y-1 hover:shadow-lg flex justify-between items-center p-5 cursor-pointer">

    {{-- Linker deel --}}
    <div>
        <span class="text-gray-800 font-semibold text-lg">{{ $activity->name }}</span>
        <div class="text-gray-600 text-sm mt-1">
            {{ \Illuminate\Support\Str::limit($activity->description, 30) }}
        </div>
        <div class="text-gray-500 text-xs mt-1">
            Locatie: {{ $activity->location ?? 'Onbekend' }}
        </div>
    </div>

    {{-- Rechter deel --}}
    <div class="flex flex-col items-end gap-2">

        {{-- Tijd --}}
        <div class="text-gray-700 text-sm">
            {{ \Carbon\Carbon::parse($activity->starttime)->format('H:i') }} -
            {{ \Carbon\Carbon::parse($activity->endtime)->format('H:i') }}
        </div>

        {{-- Acties afhankelijk van role --}}
        @if ($role === "activity")
            <form method="POST" action="{{ route('activity.enroll', $activity->id) }}" onclick="event.stopPropagation()">
                @csrf
                <input type="hidden" name="status" value="attending">
                <button type="submit"
                    class="px-4 py-1.5 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-semibold">
                    Aanwezig
                </button>
            </form>

            <form method="POST" action="{{ route('activity.enroll', $activity->id) }}" onclick="event.stopPropagation()">
                @csrf
                <input type="hidden" name="status" value="maybe">
                <button type="submit"
                    class="px-4 py-1.5 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm font-semibold">
                    Misschien
                </button>
            </form>

        @elseif ($role === "enrolled")
            <form action="{{ route('activity.unenroll', $activity->id) }}" method="POST" onclick="event.stopPropagation()">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-1.5 bg-red-500 text-white rounded hover:bg-red-600 text-sm font-semibold">
                    Afmelden
                </button>
            </form>

        @elseif ($role === "guest")
            <form method="POST" action="{{ route('activity.guest.enroll', $activity->id) }}" onclick="event.stopPropagation()">
                @csrf
                <input type="hidden" name="status" value="attending">
                <input type="hidden" name="name" value="Gast">
                <input type="hidden" name="email" value="gast@example.com">
                <button type="submit"
                    class="px-4 py-1.5 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-semibold">
                    Aanwezig
                </button>
            </form>

            <form method="POST" action="{{ route('activity.guest.enroll', $activity->id) }}" onclick="event.stopPropagation()">
                @csrf
                <input type="hidden" name="status" value="maybe">
                <input type="hidden" name="name" value="Gast">
                <input type="hidden" name="email" value="gast@example.com">
                <button type="submit"
                    class="px-4 py-1.5 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm font-semibold">
                    Misschien
                </button>
            </form>
        @endif
    </div>
</li>
