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
        Aanmelden
      </a>
    </div>
  </div>


  @if($canViewEnrollments)
    <div class="mt-10 w-4/6 mx-auto bg-white text-blue-950 rounded-lg shadow-lg p-6">
      <h3 class="text-2xl font-bold mb-4">
        Aanmeldingen {{ $amountOfEnrollments }}/{{ $activity->max_capacity }}
      </h3>

      @if($paginator->count())
        <ul class="mb-6 divide-y divide-gray-200">
          @foreach ($paginator as $participant)
            <li class="py-3 flex justify-between items-center">
              <div>
                <span class="font-semibold">{{ $participant['name'] }}</span><br>
                <span class="text-gray-500 text-sm">{{ $participant['email'] }}</span>
              </div>

              <span
                class="text-xs uppercase px-2 py-1 rounded-full 
                                                          {{ $participant['type'] === 'Gast' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }}">
                {{ $participant['type'] }}
              </span>
            </li>
          @endforeach
        </ul>

        <!-- Pagination links -->
        <div class="mt-6 flex justify-center">
          {{ $paginator->withQueryString()->links('pagination.tailwind-nl') }}
        </div>
      @else
        <p class="py-2 text-gray-600">Nog geen deelnemers.</p>
      @endif
    </div>
  @else
    <p class="py-2 text-gray-600">
      Je hebt geen toegang om de deelnemerslijst te bekijken.
    </p>
  @endif

</x-app-layout>