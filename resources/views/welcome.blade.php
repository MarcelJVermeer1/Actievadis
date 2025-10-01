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
            <p class="text-2xl font-akshar text-gray-800 mt-2">
                Welkom bij
                <span class="inline-block" aria-hidden="true">
                    <span class="text-amber-500">Actie</span><span class="text-blue-950">vadis</span>
                </span>
            </p>
        </div>

        <div class="mt-6 space-y-4">
            <p class="text-sm text-gray-700">
                Dit is de startpagina van de applicatie. Gebruik de navigatie bovenaan om door de verschillende secties te bladeren.
            </p>
            <div class="flex justify-center gap-4">
                <div>
                    <button
                        class="px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600"
                        title="Klik hier om de lijst van opkomende activiteiten te zien">
                        Opkomende Activiteiten
                    </button>
                </div>
            </div>
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
</body>

</html>