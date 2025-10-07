<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6 mt-8">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold mb-4">Ingeschreven activiteiten:</h2>
                <x-activity-filter type="enrolled" />
            </div>

            <ul class="grid grid-cols-1  gap-6 cursor-pointer">
                <x-activity-list :activities="$enrolledActivities" :role="'enrolled'"></x-activity-list>
            </ul>

            <div class="mt-4">
                {{ $enrolledActivities->links() }}
            </div>

        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6 mt-8">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Beschikbare activiteiten:</h2>
                <x-activity-filter type="available" />
            </div>

            <ul class="grid grid-cols-1  gap-6 cursor-pointer">
                <x-activity-list :activities="$availableActivities" :role="'activity'"></x-activity-list>
            </ul>

            <div class="mt-4">
                {{ $availableActivities->links() }}
            </div>

        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6 mt-8">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold mb-4">Verlopen activiteiten:</h2>
                <x-activity-filter type="old" />
            </div>

            <ul class="grid grid-cols-1  gap-6 cursor-pointer">
                <x-activity-list :activities="$oldActivities" :role="'none'"></x-activity-list>
            </ul>

            <div class="mt-4">
                {{ $oldActivities->links() }}
            </div>

        </div>
    </div>

</x-app-layout>