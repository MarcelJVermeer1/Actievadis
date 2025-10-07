<!-- resources/views/activities/create.blade.php -->
@php
use App\EnrollmentVisibility;
@endphp

<x-app-layout>
  <div class="max-w-3xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Aanmaken Activiteit</h1>

    <form action="{{ route('activities.store') }}" method="POST" class="bg-white p-8 rounded-2xl shadow-md space-y-6">
      @csrf
      <!-- Name -->
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Naam</label>
        <input type="text" name="name" id="name"
          class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          value="{{ old('name') }}" required>
      </div>

      <!-- Location -->
      <div>
        <label for="location" class="block text-sm font-medium text-gray-700">Locatie</label>
        <input type="text" name="location" id="location"
          class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          value="{{ old('location') }}" required>
      </div>

      <!-- Food (boolean) -->
      <div class="flex items-center">
        <input type="hidden" name="food" value="0">
        <input type="checkbox" name="food" id="food" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
          {{ old('food') ? 'checked' : '' }}>
        <label for="food" class="ml-2 block text-sm text-gray-700">Inclusief eten</label>
      </div>

      <!-- Description -->
      <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Beschrijving</label>
        <textarea name="description" id="description" rows="4"
          class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
      </div>

      <!-- Start Time -->
      <div>
        <label for="starttime" class="block text-sm font-medium text-gray-700">Start Tijd</label>
        <input type="datetime-local" name="starttime" id="starttime"
          class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          value="{{ old('starttime') }}" required>
      </div>

      <!-- End Time -->
      <div>
        <label for="endtime" class="block text-sm font-medium text-gray-700">Eind Tijd</label>
        <input type="datetime-local" name="endtime" id="endtime"
          class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          value="{{ old('endtime') }}" required>
      </div>

      <!-- Costs -->
      <div>
        <label for="costs" class="block text-sm font-medium text-gray-700">
          Kosten (€)
        </label>
        <input type="text" name="costs" id="costs" inputmode="decimal" pattern="^\d+(,\d{1,2})?$"
          class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          placeholder="0,00" value="{{ old('costs') }}" required>
      </div>

      <!-- max -->
      <div>
        <label for="max_capacity" class="block text-sm font-medium text-gray-700">
          Maximum aanmeldingen
        </label>
        <input type="number" name="max_capacity" id="max_capacity" inputmode="numeric" pattern="^\d+(,)?$"
          class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          placeholder="1" min="1" value="{{ old('max_capacity') }}" required>
      </div>

      <!-- Visibility -->
      <div class="mt-4">
        <label for="visibility" class="block text-sm font-medium text-gray-700">
          Wie mag inzien wie is ingeschreven
        </label>
        <select name="visibility" id="visibility"
          class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          required>
            @foreach (EnrollmentVisibility::cases() as $visibility)
            <option value="{{ $visibility->value }}" {{ old('visibility') === $visibility->value ? 'selected' : '' }}>
              {{ ucfirst($visibility->value) }}
            </option>
          @endforeach
        </select>
      </div>


      <!-- Submit Button -->
      <div class="text-center">
        <button type="submit"
          class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl shadow hover:bg-indigo-700 transition">
          Aanmaken
        </button>
      </div>
      <!-- Error display -->
      @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mt-6" role="alert">
          <strong class="font-bold">Oeps!</strong>
          <span class="block sm:inline">Er zijn enkele problemen met de ingevoerde gegevens.</span>
          <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </form>
  </div>
</x-app-layout>