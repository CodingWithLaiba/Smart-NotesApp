<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: '{{ auth()->user()?->theme === 'dark' ? 'true' : 'false' }}' === 'true' }"
      :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart Notes — @yield('title', 'Home')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen">

    {{-- Top Navigation Bar --}}
    @include('partials.navbar')

    <div class="flex">
        
        {{-- Main Content Area --}}
        <main class="flex-1 p-6">

            {{-- Flash success message --}}
            @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
            @endif

            {{-- Flash error message --}}
            @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </main>

    </div>

</body>

</html>