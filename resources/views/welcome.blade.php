<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Actievadis') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="flex flex-col justify-center items-center min-h-screen bg-gray-100 p-4">
        <div class="text-center mt-8">
            <p class="text-4xl font-akshar text-gray-800     mt-2">
                Welkom bij
                <span class="inline-block" aria-hidden="true">
                    <span class="text-amber-500">Actie</span><span class="text-blue-950">vadis</span>
                </span>
            </p>
        </div>

        <div>
            <p class="text-sm text-gray-700">
                Hier kan je de opkomende activiteiten vinden die door onze organisatie worden aangeboden.
            </p>
        </div>

        <div class="mt-6 space-y-4 w-8/12">
            @php
            $activityCount = count($activitiesList);
            $gridColsClass = $activityCount === 1 ? 'grid-cols-1' : ($activityCount === 2 ? 'grid-cols-2' : 'grid-cols-3');
            $displayedActivities = $activitiesList->take(3);
            @endphp

            @if ($displayedActivities->count() > 0)
            <div class="grid gap-6 {{ $gridColsClass }}">
                @foreach ($displayedActivities as $activity)
                <div class="block">
                    <x-activity-card :activity="$activity" />
                </div>
                @endforeach
            </div>
            @else
            <p class="text-lg font-medium text-gray-700">
                Er zijn op dit moment geen activiteiten gepland <i class="fa-regular fa-face-frown"></i>
            </p>
            @endif
        </div>

        <div>
            <x-application-logo class="absolute top-4 left-4 h-12 w-auto fill-current text-gray-800" />

            @if (Route::has('login'))
            <nav class="absolute top-4 right-4 flex items-center justify-end gap-4">
                @auth
                <a
                    href="{{ url('/dashboard') }}"
                    class="inline-block px-5 py-1.5 text-[#1b1b18] border border-black hover:border-yellow-500 hover:bg-gray-200 rounded-full text-sm leading-normal">
                    Dashboard
                </a>
                @else
                <a
                    href="{{ route('login') }}"
                    class="inline-block px-5 py-1.5 text-[#1b1b18] border border-black hover:border-yellow-500 hover:bg-gray-200 rounded-full text-sm leading-normal">
                    Log in
                </a>

                @if (Route::has('register'))
                <a
                    href="{{ route('register') }}"
                    class="inline-block px-5 py-1.5 text-[#1b1b18] border border-black hover:border-yellow-500 hover:bg-gray-200 rounded-full text-sm leading-normal">
                    Registreer hier
                </a>
                @endif
                @endauth
            </nav>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div id="enrollment-modal" class="fixed inset-0 hidden bg-gray-500/75">
        <div class="absolute top-[50%] left-[50%] transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Schrijf je in voor deze activiteit</h3>
                <x-application-logo class="absolute bottom-4 left-4 h-5 w-auto fill-current text-gray-800" />
            </div>
            <p class="text-xs text-gray-500 text-opacity-70 mb-4">Na het inschrijven zal je een bevestiging ontvangen op je e-mailadres.</p>
            <form id="enrollment-form" method="POST" action="{{ route('guest.enrollment.store') }}">
                @csrf
                <input type="hidden" name="activity_id" id="activity-id">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Naam</label>
                    <input type="text" name="name" id="name" placeholder="Vul hier je naam in." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="Vul hier je e-mailadres in." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()" class="mr-2 rounded-md bg-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-400">Annuleren</button>
                    <button type="submit" class="rounded-md bg-amber-500 px-4 py-2 text-sm font-medium text-white hover:bg-amber-600">Inschrijven</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal functionality -->
    <script>
        function openModal(activityId) {
            document.getElementById('activity-id').value = activityId;
            document.getElementById('enrollment-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('enrollment-modal').classList.add('hidden');
        }

        // Close modal if clicking outside of it
        document.getElementById('enrollment-modal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });
    </script>
</body>

</html>
<x-wrappers.toast-wrapper></x-wrappers.toast-wrapper>