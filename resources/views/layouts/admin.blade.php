<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — SmartNotes Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style> body { font-family: 'Outfit', sans-serif; } </style>
</head>

<body class="bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-gray-100 min-h-screen">

    <div class="flex min-h-screen">

        {{-- Admin Sidebar --}}
        <aside class="w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 fixed inset-y-0 left-0 flex flex-col z-30">

            {{-- Logo --}}
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-gray-900 dark:text-white text-sm">SmartNotes</h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Admin Panel</p>
                    </div>
                </div>
            </div>

            {{-- Nav Items --}}
            <nav class="flex-1 px-3 py-4 space-y-1">
                @php
                    $adminLinks = [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard'],
                        ['route' => 'admin.users.index', 'label' => 'Users', 'icon' => 'users'],
                        ['route' => 'admin.notes.index', 'label' => 'All Notes', 'icon' => 'file-text'],
                        ['route' => 'admin.categories.index', 'label' => 'Categories', 'icon' => 'folder'],
                        ['route' => 'admin.tags.index', 'label' => 'Tags', 'icon' => 'tag'],
                    ];
                @endphp

                @foreach($adminLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150
                              {{ request()->routeIs($link['route']) 
                                 ? 'bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400' 
                                 : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                        <i data-lucide="{{ $link['icon'] }}" class="w-4 h-4"></i>
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- Bottom Actions --}}
            <div class="px-3 py-4 border-t border-gray-200 dark:border-gray-800 space-y-1">
                <a href="{{ route('notes.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to App
                </a>
                <button @click="darkMode = !darkMode"
                        class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <i data-lucide="sun" class="w-4 h-4 dark:hidden"></i>
                    <i data-lucide="moon" class="w-4 h-4 hidden dark:block"></i>
                    <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'">Dark Mode</span>
                </button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 ml-64 flex flex-col min-h-screen">
            <header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 px-6 py-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">@yield('page-title', 'Dashboard')</h2>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->name }}</span>
                    <div class="w-8 h-8 bg-gradient-to-br from-sky-400 to-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6">
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                         class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 rounded-xl flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>lucide.createIcons();</script>
    @stack('scripts')
</body>
</html>