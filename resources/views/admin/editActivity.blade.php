@php
  use App\EnrollmentVisibility;

@endphp

<x-app-layout>
  <div class="max-w-3xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Activiteit bewerken</h1>

    <form method="POST" action="{{ route('activities.update', $activity->id) }}" enctype="multipart/form-data"
      class="space-y-6 bg-white p-8 rounded-2xl shadow">
      @csrf
      @method('PUT')

      <div>
        <label class="block font-medium">Naam</label>
        <input type="text" name="name" value="{{ old('name', $activity->name) }}" class="w-full border rounded-lg p-2"
          required>
      </div>

      <div>
        <label class="block font-medium">Locatie</label>
        <input type="text" name="location" value="{{ old('location', $activity->location) }}"
          class="w-full border rounded-lg p-2" required>
      </div>

      <div>
        <label class="block font-medium">Beschrijving</label>
        <textarea name="description" rows="4" class="w-full border rounded-lg p-2"
          required>{{ old('description', $activity->description) }}</textarea>
      </div>
      <!-- Food (boolean) -->
      <div class="flex items-center">
        <input type="hidden" name="food" value="0">
        <input type="checkbox" name="food" id="food" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
          {{ old('food') ? 'checked' : '' }}>
        <label for="food" class="ml-2 block text-sm text-gray-700">Inclusief eten</label>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block font-medium">Starttijd</label>
          <input type="datetime-local" name="starttime"
            value="{{ old('starttime', date('Y-m-d\TH:i', strtotime($activity->starttime))) }}"
            class="w-full border rounded-lg p-2" required>
        </div>
        <div>
          <label class="block font-medium">Eindtijd</label>
          <input type="datetime-local" name="endtime"
            value="{{ old('endtime', date('Y-m-d\TH:i', strtotime($activity->endtime))) }}"
            class="w-full border rounded-lg p-2" required>
        </div>
      </div>

      <div>
        <label class="block font-medium">Kosten (€)</label>
        <input type="text" name="costs" value="{{ old('costs', $activity->costs) }}"
          class="w-full border rounded-lg p-2" required>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block font-medium">Min deelnemers</label>
          <input type="number" name="min" value="{{ old('min', $activity->min) }}" class="w-full border rounded-lg p-2">
        </div>
        <div>
          <label class="block font-medium">Max deelnemers</label>
          <input type="number" name="max_capacity" value="{{ old('max_capacity', $activity->max_capacity) }}"
            class="w-full border rounded-lg p-2" required>
        </div>
      </div>

      <div>
        <label class="block font-medium">Benodigdheden</label>
        <input type="text" name="necessities" value="{{ old('necessities', $activity->necessities) }}"
          class="w-full border rounded-lg p-2">
      </div>

      <div>
        <label class="block font-medium">Zichtbaarheid</label>
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

      <div>
        <label class="block font-medium mb-2">Afbeelding</label>
        @if($activity->image)
          <img src="data:image/jpeg;base64,{{ base64_encode($activity->image) }}" alt="Huidige afbeelding"
            class="w-full max-h-60 object-cover rounded-lg mb-3">
        @endif
        <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-500">
        <p class="text-xs text-gray-400 mt-1">Laat leeg om huidige afbeelding te behouden.</p>
      </div>

      <div class="flex justify-end space-x-3">
        <a href="{{ route('activity.show', $activity->id) }}"
          class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">Annuleren</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Opslaan</button>
      </div>
    </form>
  </div>
</x-app-layout>