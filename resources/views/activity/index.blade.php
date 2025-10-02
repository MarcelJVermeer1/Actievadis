<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Ingeschreven activiteiten --}}
        <div class="bg-white shadow rounded-lg p-6 mt-8">
            <h2 class="text-2xl font-bold mb-4">Ingeschreven activiteiten</h2>
            <ul class="grid grid-cols-1 gap-6 cursor-pointer">
                @forelse($enrolledActivities as $activity)
                    <x-activity-item :activity="$activity" role="enrolled" />
                @empty
                    <li class="py-3 text-gray-500">Geen activiteiten gevonden.</li>
                @endforelse
            </ul>
        </div>

        {{-- Beschikbare activiteiten --}}
        <div class="bg-white shadow rounded-lg p-6 mt-8">
            <h2 class="text-2xl font-bold mb-4">Beschikbare activiteiten</h2>
            <ul class="grid grid-cols-1 gap-6 cursor-pointer">
                @forelse($availableActivities as $activity)
                    <x-activity-item :activity="$activity" role="activity" />
                @empty
                    <li class="py-3 text-gray-500">Geen activiteiten gevonden.</li>
                @endforelse
            </ul>
        </div>

        {{-- Verlopen activiteiten --}}
        <div class="bg-white shadow rounded-lg p-6 mt-8">
            <h2 class="text-2xl font-bold mb-4">Verlopen activiteiten</h2>
            <ul class="grid grid-cols-1 gap-6 cursor-pointer">
                @forelse($oldActivities as $activity)
                    <x-activity-item :activity="$activity" role="none" />
                @empty
                    <li class="py-3 text-gray-500">Geen activiteiten gevonden.</li>
                @endforelse
            </ul>
        </div>

    </div>
</x-app-layout>
