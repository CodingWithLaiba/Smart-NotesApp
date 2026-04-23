<!-- left sidebar (categories/tags) -->
<aside class="w-60 bg-gray-900 text-gray-100 p-4 flex flex-col gap-1">
    <div class="text-lg font-bold mb-4">Admin Panel</div>
    <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800' : '' }}">Dashboard</a>
    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.users.*') ? 'bg-gray-800' : '' }}">Users</a>
    <a href="{{ route('admin.notes.index') }}" class="px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.notes.*') ? 'bg-gray-800' : '' }}">All Notes</a>
    <a href="{{ route('notes.index') }}" class="px-3 py-2 rounded hover:bg-gray-800 mt-auto text-sm text-gray-400">← Back to app</a>
</aside>