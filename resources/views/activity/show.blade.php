<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activiteiten') }}
        </h2>
    </x-slot>




    <div class="my-10 min-h-[40vh] w-4/6 mx-auto bg-blue-950 text-white rounded-lg shadow-lg p-10 space-y-6">

        <h1 class="text-5xl font-bold text-center">{{ $activity->name }}</h1>

        <p class="text-lg text-orange-400 mx-auto">Omschrijving</p>
        <p class="text-lg">{{ $activity->description }}</p>
        <p class="text-lg text-orange-400">Kosten: €{{ number_format($activity->costs, 2) }}</p>
        <p class="text-lg text-orange-400">Inclusief eten: {{ $activity->food ? 'Ja' : 'Nee' }}</p>
        <div class="grid grid-flow-col gap-4">
            <h4 class="text-xl text-orange-400">Locatie (M)</h4>
            <h4 class="text-xl ">{{ $activity->location }}</h4>
        </div>
        <div class="grid grid-flow-col">

            <p class="text-lg text-orange-400">Date: </p>
            <p class="text-lg">
                Begin tijd: {{ \Carbon\Carbon::parse($activity->starttime)->format('d-m-Y H:i') }}
            </p>
            <p class="text-lg">
                Eind tijd: {{ \Carbon\Carbon::parse($activity->endtime)->format('d-m-Y H:i') }}
            </p>
        </div>


        <div class="flex justify-center gap-6 pt-6">
            <a href="{{ route('activity.enroll', $activity->id) }}"
               class="px-8 py-3 border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white rounded-lg font-semibold text-lg">
                Aanwezig
            </a>
            <a href="{{ route('activity.enroll', $activity->id) }}"
               class="px-8 py-3 border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white rounded-lg font-semibold text-lg">
                Misschien
            </a>
        </div>
    </div>


</x-app-layout>
