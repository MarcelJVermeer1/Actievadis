@props(['activity'])

<div class="bg-white rounded-lg shadow-md overflow-hidden p-4">
    <h3 class="text-lg font-semibold text-gray-800">{{ \Illuminate\Support\Str::limit($activity->name, 25) }}</h3>
    <p class="text-sm text-gray-600 mt-1">{{ \Illuminate\Support\Str::limit($activity->description, 50) }}</p>
    <p class="text-xs text-gray-500 mt-1">Locatie: {{ $activity->location ?? 'Onbekend' }}</p>
    <div class="flex justify-between items-center">
        <p class="text-xs text-gray-500 mt-1">
            Tijd: {{ \Carbon\Carbon::parse($activity->starttime)->format('H:i') }} -
            {{ \Carbon\Carbon::parse($activity->endtime)->format('H:i') }}
        </p>
        <button onclick="openModal('{{ $activity->id }}')" class="rounded-md bg-gray-950/5 px-2.5 py-1.5 text-sm font-semibold text-gray-900 hover:bg-gray-950/10">Schrijf je in</button>
    </div>
</div>