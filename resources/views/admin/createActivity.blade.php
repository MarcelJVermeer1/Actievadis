<!-- resources/views/activities/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Create Activity</h1>

    <form action="{{ route('activities.store') }}" method="POST" class="bg-white p-8 rounded-2xl shadow-md space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" 
                   class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                   required>
        </div>

        <!-- Location -->
        <div>
            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
            <input type="text" name="location" id="location" 
                   class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                   required>
        </div>

        <!-- Food (boolean) -->
        <div class="flex items-center">
            <input type="checkbox" name="food" id="food" value="1" 
                   class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
            <label for="food" class="ml-2 block text-sm text-gray-700">Includes Food</label>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
        </div>

        <!-- Start Time -->
        <div>
            <label for="starttime" class="block text-sm font-medium text-gray-700">Start Time</label>
            <input type="datetime-local" name="starttime" id="starttime"
                   class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                   required>
        </div>

        <!-- End Time -->
        <div>
            <label for="endtime" class="block text-sm font-medium text-gray-700">End Time</label>
            <input type="datetime-local" name="endtime" id="endtime"
                   class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                   required>
        </div>

        <!-- Costs -->
        <div>
            <label for="costs" class="block text-sm font-medium text-gray-700">Costs ($)</label>
            <input type="number" name="costs" id="costs" step="0.01" 
                   class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                   required>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" 
                    class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl shadow hover:bg-indigo-700 transition">
                Create Activity
            </button>
        </div>
    </form>
</div>
@endsection
