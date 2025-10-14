<x-app-layout>
    {{-- 🔹 Ingeschreven activiteiten --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6 mt-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Ingeschreven activiteiten:</h2>
                <x-activity-filter type="enrolled" />
            </div>

            <ul class="grid grid-cols-1 gap-6 cursor-pointer">
                <x-activity-list :activities="$enrolledActivities" :role="'enrolled'" />
            </ul>

            @if ($enrolledActivities->hasPages())
                <div class="mt-6 flex justify-center">
                    {{-- ✅ Gebruik je Nederlandse Tailwind paginatiecomponent --}}
                    {{ $enrolledActivities->withQueryString()->links('pagination.tailwind-nl') }}
                </div>
            @endif
        </div>
    </div>

    {{-- 🔹 Beschikbare activiteiten --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6 mt-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Beschikbare activiteiten:</h2>
                <x-activity-filter type="available" />
            </div>

            <ul class="grid grid-cols-1 gap-6 cursor-pointer">
                <x-activity-list :activities="$availableActivities" :role="'activity'" />
            </ul>

            @if ($availableActivities->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $availableActivities->withQueryString()->links('pagination.tailwind-nl') }}
                </div>
            @endif
        </div>
    </div>

    {{-- 🔹 Verlopen activiteiten --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6 mt-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Verlopen activiteiten:</h2>
                <x-activity-filter type="old" />
            </div>

            <ul class="grid grid-cols-1 gap-6 cursor-pointer">
                <x-activity-list :activities="$oldActivities" :role="'none'" />
            </ul>

            @if ($oldActivities->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $oldActivities->withQueryString()->links('pagination.tailwind-nl') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>