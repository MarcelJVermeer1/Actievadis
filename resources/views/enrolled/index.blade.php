<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6 mt-8">
            <h2 class="text-2xl font-bold mb-4">Ingeschreven activiteiten:</h2>
            <ul class="grid grid-cols-1  gap-6 cursor-pointer">
                <x-activity-list :activities="$enrolledActivities"></x-activity-list>
            </ul>
        </div>
    </div>
</x-app-layout>