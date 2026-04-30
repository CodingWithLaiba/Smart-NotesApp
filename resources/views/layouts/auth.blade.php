<!DOCTYPE html>
<html lang="en"
    x-data="{ darkMode: (() => { const saved = localStorage.getItem('darkMode'); if (saved !== null) return saved === 'true'; return false; })() }"
    x-init="
        document.documentElement.classList.toggle('dark', darkMode);
        $watch('darkMode', value => {
            localStorage.setItem('darkMode', value ? 'true' : 'false');
            document.documentElement.classList.toggle('dark', value);
        });
    ">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Auth') — SmartNotes</title>

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

<body class="bg-gray-50 dark:bg-gray-950 min-h-screen flex items-center justify-center p-4 transition-colors duration-300">

    {{-- Dark Mode Toggle --}}
    <button type="button" @click="darkMode = !darkMode"
        class="fixed top-5 right-5 p-2.5 rounded-xl bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all z-10">
        <i data-lucide="sun" class="w-4 h-4 dark:hidden"></i>
        <i data-lucide="moon" class="w-4 h-4 hidden dark:block"></i>
    </button>

    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 group">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200 dark:shadow-blue-900/50">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <span class="font-bold text-xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    SmartNotes
                </span>
            </a>
            @if(View::hasSection('heading'))
    <div class="mt-4">
        @yield('heading')
    </div>
@endif
        </div>

        {{-- Card --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm shadow-gray-200/60 dark:shadow-gray-950/60 border border-gray-200 dark:border-gray-800 p-8">
            @yield('content')
        </div>
    </div>

    <script>lucide.createIcons();</script>
    @stack('scripts')
</body>
</html>
