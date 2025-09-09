<x-app-layout>
    @foreach ($users as $user)
    <div class="flex justify-between items-center bg-white gap-4 p-4 border-b border-gray-200">
        <div>
            <div class="flex items-center gap-4">
                <p class="text-md text-gray-800">{{ $user->name }}</p>
                <p class="text-sm text-gray-400">({{ $user->email }})</p>
                <span class="inline-flex items-center rounded-md bg-pink-400/10 px-2 py-1 text-xs font-medium text-pink-400 ring-1 ring-inset ring-pink-400">placeholder for job</span>
            </div>
        </div>

        <div>
            <form action="{{ route('usermanagement.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700" title="Delete user">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
    @endforeach
</x-app-layout>