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

        <div class="mt-6 space-y-4 w-8/12">
            @if ($activitiesList->count() > 0)
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                @foreach ($activitiesList as $activity)
                <div class="block">
                    <x-activity-card :activity="$activity" />
                </div>
                @endforeach
            </div>
            @else
            <p class="text-lg font-medium text-gray-700 text-center">
                Er zijn op dit moment geen activiteiten gepland <i class="fa-regular fa-face-frown"></i>
            </p>
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



    <!-- Modal -->
    <div id="enrollment-modal" class="fixed inset-0 hidden bg-gray-500/75 z-50 opacity-0 transition-opacity duration-300">
        <div
            class="absolute top-[50%] left-[50%] transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-xl p-6 w-full max-w-md scale-95 transition-transform duration-300">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ $activity->name }}</h3>
                <p class="text-xs text-gray-600 mb-2">{{ $activity->description }}</p>

                <x-application-logo class="absolute bottom-4 left-4 h-5 w-auto fill-current text-gray-800" />
            </div>
            <form id="enrollment-form" method="POST" action="{{ route('guest.enrollment.store') }}">
                @csrf
                <input type="hidden" name="activity_id" id="activity-id">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Naam</label>
                    <input type="text" name="name" id="name" placeholder="Vul hier je naam in."
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm"
                        required>
                </div>
                <div class="mb-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="Vul hier je e-mailadres in."
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm"
                        required>
                </div>
                <p class="text-xs text-gray-500 text-opacity-70 mb-4">Na het inschrijven zal je een bevestiging ontvangen
                    op je e-mailadres.</p>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()"
                        class="mr-2 rounded-md bg-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-400">Annuleren</button>
                    <button type="submit"
                        class="rounded-md bg-amber-500 px-4 py-2 text-sm font-medium text-white hover:bg-amber-600">Inschrijven</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Scripts -->
    <script>
        function openModal(activityId) {
            const modal = document.getElementById('enrollment-modal');
            document.getElementById('activity-id').value = activityId;
            modal.classList.remove('hidden');

            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('div').classList.remove('scale-95');
            });
        }

        function closeModal() {
            const modal = document.getElementById('enrollment-modal');

            modal.classList.add('opacity-0');
            modal.querySelector('div').classList.add('scale-95');

            modal.addEventListener('transitionend', () => {
                modal.classList.add('hidden');
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