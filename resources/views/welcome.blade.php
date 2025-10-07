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
            <p class="text-4xl font-akshar text-gray-800 mt-2">
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
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-3">
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

            @if ($activityCount > 3)
            <div class="mt-4 text-center">
                <button onclick="openDrawer()" class="rounded-md bg-gray-950/5 px-2.5 py-1.5 text-sm font-semibold text-gray-900 hover:bg-gray-950/10">
                    Bekijk alle activiteiten
                </button>
            </div>
            @endif
        </div>

        <div>
            <x-application-logo class="absolute top-4 left-4 h-12 w-auto fill-current text-gray-800" />
            @if (Route::has('login'))
            <nav class="absolute top-4 right-4 flex items-center justify-end gap-4">
                @auth
                <a href="{{ url('/dashboard') }}"
                    class="inline-block px-5 py-1.5 text-[#1b1b18] border border-black hover:border-yellow-500 hover:bg-gray-200 rounded-full text-sm leading-normal">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}"
                    class="inline-block px-5 py-1.5 text-[#1b1b18] border border-black hover:border-yellow-500 hover:bg-gray-200 rounded-full text-sm leading-normal">
                    Log in
                </a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="inline-block px-5 py-1.5 text-[#1b1b18] border border-black hover:border-yellow-500 hover:bg-gray-200 rounded-full text-sm leading-normal">
                    Registreer hier
                </a>
                @endif
                @endauth
            </nav>
            @endif
        </div>
    </div>

    <!-- Drawer -->
    <div id="drawer" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50" onclick="closeDrawer()"></div>
        <div id="drawer-panel"
            class="absolute right-0 h-full w-full max-w-md bg-white shadow-xl transform translate-x-full transition-transform duration-500 ease-in-out">
            <div class="flex h-full flex-col overflow-y-auto py-6">
                <div class="px-4 sm:px-6 flex items-start justify-between">
                    <h2 class="text-base font-semibold text-gray-900">Alle Activiteiten</h2>
                    <button onclick="closeDrawer()" type="button"
                        class="ml-3 rounded-md text-gray-400 hover:text-gray-500 focus:outline-none">
                        <span class="sr-only">Close panel</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                            class="h-6 w-6">
                            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <div class="relative mt-6 flex-1 px-4 sm:px-6">
                    <ul class="divide-y divide-gray-200">
                        @foreach ($activitiesList as $activity)
                        <li class="py-4">
                            <x-activity-card :activity="$activity" />
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <x-application-logo class="absolute bottom-4 left-4 h-5 w-auto fill-current text-gray-800 mt-2" />
        </div>
    </div>

    <!-- Modal -->
    <div id="enrollment-modal" class="fixed inset-0 hidden bg-gray-500/75 z-50 opacity-0 transition-opacity duration-300">
        <div
            class="absolute top-[50%] left-[50%] transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-xl p-6 w-full max-w-md scale-95 transition-transform duration-300">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Schrijf je in voor deze activiteit</h3>
                <x-application-logo class="absolute bottom-4 left-4 h-5 w-auto fill-current text-gray-800" />
            </div>
            <p class="text-xs text-gray-500 text-opacity-70 mb-4">Na het inschrijven zal je een bevestiging ontvangen
                op je e-mailadres.</p>
            <div id="activity-description" class="text-sm text-gray-700 mb-4"></div>
            <form id="enrollment-form" method="POST" action="{{ route('guest.enrollment.store') }}">
                @csrf
                <input type="hidden" name="activity_id" id="activity-id">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Naam</label>
                    <input type="text" name="name" id="name" placeholder="Vul hier je naam in."
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm"
                        required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="Vul hier je e-mailadres in."
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm"
                        required>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()"
                        class="mr-2 rounded-md bg-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-400">Annuleren</button>
                    <button type="submit"
                        class="rounded-md bg-amber-500 px-4 py-2 text-sm font-medium text-white hover:bg-amber-600">Inschrijven</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Drawer + Modal Scripts -->
    <script id="activity-data" type="application/json">
        @json($activitiesList->pluck('description', 'id'))
    </script>
    <script>
        // Map of activity id -> description so modal can show full description for guest signups
        const activityDescriptions = (function() {
            const el = document.getElementById('activity-data');
            try {
                return el ? JSON.parse(el.textContent) : {};
            } catch (e) {
                return {};
            }
        })();

        function openDrawer() {
            const drawer = document.getElementById('drawer');
            const panel = document.getElementById('drawer-panel');
            drawer.classList.remove('hidden');

            panel.offsetHeight;

            panel.classList.remove('translate-x-full');
        }

        function closeDrawer() {
            const panel = document.getElementById('drawer-panel');
            const drawer = document.getElementById('drawer');
            panel.classList.add('translate-x-full');
            panel.addEventListener('transitionend', () => {
                drawer.classList.add('hidden');
            }, {
                once: true
            });
        }

        function openModal(activityId) {
            const modal = document.getElementById('enrollment-modal');
            document.getElementById('activity-id').value = activityId;
            // Populate the activity description (preserve newlines)
            const desc = activityDescriptions && activityDescriptions[activityId] ? activityDescriptions[activityId] : '';
            const descDiv = document.getElementById('activity-description');
            if (descDiv) {
                // convert newlines to <br> for basic formatting
                descDiv.innerHTML = desc ? desc.replace(/\n/g, '<br>') : '';
            }
            modal.classList.remove('hidden');

            // Trigger fade-in and scale-in effect
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('div').classList.remove('scale-95');
            });

            closeDrawer();
        }

        function closeModal() {
            const modal = document.getElementById('enrollment-modal');

            // Trigger fade-out and scale-out effect
            modal.classList.add('opacity-0');
            modal.querySelector('div').classList.add('scale-95');

            modal.addEventListener('transitionend', () => {
                modal.classList.add('hidden');
                // clear description when closed
                const descDiv = document.getElementById('activity-description');
                if (descDiv) {
                    descDiv.innerHTML = '';
                }
            }, {
                once: true
            });
        }

        document.getElementById('enrollment-modal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });
    </script>

    <style>
        @media (max-width: 640px) {
            .login-register-buttons {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
        }
    </style>
</body>

</html>
<x-wrappers.toast-wrapper></x-wrappers.toast-wrapper>