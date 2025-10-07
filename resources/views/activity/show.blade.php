<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activiteiten') }}
        </h2>
    </x-slot>

    <div class="my-10 min-h-[40vh] max-w-4xl mx-auto bg-white text-gray-900 rounded-xl shadow-md p-8 space-y-6 border border-gray-100">

        <header class="text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold">
                <span class="block text-amber-500">{{ $activity->name }}</span>
            </h1>
            <p class="mt-2 text-sm text-gray-500">Bekijk de details en meld je aan</p>
        </header>

        <section class="space-y-4">
            <h2 class="text-sm font-medium text-amber-500">Omschrijving</h2>
            <p class="text-base text-gray-700">{{ $activity->description }}</p>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="col-span-1 bg-gray-50 rounded-md p-4 border border-gray-100">
                <p class="text-xs text-gray-500">Kosten</p>
                <p class="mt-1 font-semibold text-gray-900">€{{ number_format($activity->costs, 2) }}</p>
            </div>

            <div class="col-span-1 bg-gray-50 rounded-md p-4 border border-gray-100">
                <p class="text-xs text-gray-500">Inclusief eten</p>
                <p class="mt-1 font-semibold text-gray-900">{{ $activity->food ? 'Ja' : 'Nee' }}</p>
            </div>

            <div class="col-span-1 bg-gray-50 rounded-md p-4 border border-gray-100">
                <p class="text-xs text-gray-500">Locatie</p>
                <p class="mt-1 font-semibold text-gray-900">{{ $activity->location }}</p>
            </div>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="rounded-md p-4 bg-white border border-gray-100">
                <p class="text-xs text-gray-500">Begin tijd</p>
                <p class="mt-1 text-gray-800 font-medium">{{ \Carbon\Carbon::parse($activity->starttime)->format('d-m-Y H:i') }}</p>
            </div>
            <div class="rounded-md p-4 bg-white border border-gray-100">
                <p class="text-xs text-gray-500">Eind tijd</p>
                <p class="mt-1 text-gray-800 font-medium">{{ \Carbon\Carbon::parse($activity->endtime)->format('d-m-Y H:i') }}</p>
            </div>
        </section>

        <footer class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <a href="{{ route('activity.enroll', $activity->id) }}"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-md shadow-sm transition">
                Aanwezig
            </a>

            <a href="{{ route('activity.enroll', $activity->id) }}"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 border border-amber-500 text-amber-500 hover:bg-amber-50 rounded-md font-semibold transition">
                Misschien
            </a>
        </footer>

    </div>

</x-app-layout>