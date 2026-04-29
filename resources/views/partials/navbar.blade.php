<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">

        {{-- Left Side: Logo + Links --}}
        <div class="flex items-center gap-6">

            {{-- Logo --}}
            <a href="{{ route('notes.index') }}" class="flex items-center gap-2 group">
                <div class="w-8 h-8 bg-linear-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center transform group-hover:scale-110 transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <span class="text-xl font-bold bg-linear-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    SmartNotes
                </span>
            </a>

            @auth
            {{-- Navigation Links --}}
            <div class="hidden md:flex items-center gap-4 text-sm">
                <a href="{{ route('notes.index') }}" class="hover:text-indigo-600">Notes</a>
                <a href="{{ route('categories.index') }}" class="hover:text-indigo-600">Categories</a>
                <a href="{{ route('tags.index') }}" class="hover:text-indigo-600">Tags</a>
                <a href="{{ route('trash.index') }}" class="hover:text-indigo-600">Trash</a>

                @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="text-amber-600 hover:underline">
                    Admin
                </a>
                @endif
            </div>
            @endauth

        </div>

        {{-- Right Side --}}
        <div class="flex items-center gap-3 text-sm">

            @auth

            {{-- Search bar --}}
            <form method="GET" action="{{ route('notes.index') }}" class="hidden md:block">
                <div class="relative">
                    <input
                        type="text"
                        name="search"
                        placeholder="Search notes..."
                        value="{{ request('search') }}"
                        class="w-64 pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>

            {{-- Dark mode toggle --}}
            <button type="button" @click="darkMode = !darkMode"
                        class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <!-- <i data-lucide="sun" class="w-4 h-4 dark:hidden"></i>
                    <i data-lucide="moon" class="w-4 h-4 hidden dark:block"></i> -->
                    <span x-text="darkMode ? '🌙 Dark Mode' : '☀️ Light Mode'">Dark Mode</span>
                </button>

            {{-- User dropdown --}}
            <div class="flex items-center gap-3 px-3 py-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <div class="w-8 h-8 bg-linear-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="hidden md:block">
                    <p class="font-medium text-gray-700 dark:text-gray-200">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition" title="Profile">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button class="p-2 rounded-lg hover:bg-red-50 text-red-600 dark:hover:bg-red-900/20 transition" title="Logout">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>

            @else
            <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition font-medium">Login</a>
            <a href="{{ route('register') }}" class="px-4 py-2 bg-linear-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:shadow-lg transition font-medium">Get Started</a>

            @endauth

        </div>
    </div>
</nav>