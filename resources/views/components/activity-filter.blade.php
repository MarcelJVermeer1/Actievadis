@props(['type'])

<div x-data="{ open: false }" class="relative mb-4 flex justify-end">
    <!-- Filterknop -->
    <button @click="open = !open" class="bg-gray-100 px-4 py-2 rounded flex items-center gap-2 hover:bg-gray-200">
        <i class="fa fa-filter"></i> Filter
    </button>

    <!-- Dropdown -->
    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 bg-white shadow rounded w-40 z-10">

        @php
            // Huidige sorteerwaarde ophalen, bv. sort_available
            $param = "sort_{$type}";
            $current = request($param, 'date_asc');
        @endphp

        <a href="?{{ $param }}=az"
            class="block px-4 py-2 hover:bg-gray-100 {{ $current === 'az' ? 'bg-blue-100 font-semibold' : '' }}">
            🔼 A/Z
        </a>

        <a href="?{{ $param }}=za"
            class="block px-4 py-2 hover:bg-gray-100 {{ $current === 'za' ? 'bg-blue-100 font-semibold' : '' }}">
            🔽 Z/A
        </a>

        <a href="?{{ $param }}=date_asc"
            class="block px-4 py-2 hover:bg-gray-100 {{ $current === 'date_asc' ? 'bg-blue-100 font-semibold' : '' }}">
            ⏳ Af oplopen
        </a>

        <a href="?{{ $param }}=date_desc"
            class="block px-4 py-2 hover:bg-gray-100 {{ $current === 'date_desc' ? 'bg-blue-100 font-semibold' : '' }}">
            🕒 Oploden
        </a>
    </div>
</div>