<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Account — NoteVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class', theme: { extend: { fontFamily: { sans: ['Outfit', 'sans-serif'] } } } }</script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style> body { font-family: 'Outfit', sans-serif; } </style>
</head>

<body class="bg-gray-50 dark:bg-gray-950 min-h-screen flex items-center justify-center p-4 transition-colors duration-300">

    {{-- Dark Mode Toggle --}}
    <button @click="darkMode = !darkMode"
            class="fixed top-5 right-5 p-2.5 rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all z-10">
        <i data-lucide="sun" class="w-4 h-4 dark:hidden"></i>
        <i data-lucide="moon" class="w-4 h-4 hidden dark:block"></i>
    </button>

    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-2.5 group">
                <div class="w-10 h-10 bg-gradient-to-br from-sky-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-sky-200 dark:shadow-sky-900/50">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="font-bold text-xl text-gray-900 dark:text-white">NoteVault</span>
            </a>
            <h1 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">Create your account</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Start capturing your ideas today</p>
        </div>

        {{-- Card --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm shadow-gray-200/60 dark:shadow-gray-950/60 border border-gray-200 dark:border-gray-800 p-8">

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="flex items-start gap-2 text-sm text-red-600 dark:text-red-400">
                                <i data-lucide="alert-circle" class="w-4 h-4 mt-0.5 flex-shrink-0"></i>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Full Name
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                        </div>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               placeholder="John Doe"
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border rounded-xl
                                      {{ $errors->has('name') ? 'border-red-300 dark:border-red-700' : 'border-gray-200 dark:border-gray-700' }}
                                      focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent focus:bg-white dark:focus:bg-gray-700
                                      text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition-all">
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="w-4 h-4 text-gray-400"></i>
                        </div>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               placeholder="you@example.com"
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border rounded-xl
                                      {{ $errors->has('email') ? 'border-red-300 dark:border-red-700' : 'border-gray-200 dark:border-gray-700' }}
                                      focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent focus:bg-white dark:focus:bg-gray-700
                                      text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition-all">
                    </div>
                </div>

                {{-- Password --}}
                <div x-data="{ show: false }">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="w-4 h-4 text-gray-400"></i>
                        </div>
                        <input :type="show ? 'text' : 'password'"
                               id="password"
                               name="password"
                               required
                               placeholder="Min. 8 characters"
                               class="w-full pl-10 pr-10 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border rounded-xl
                                      {{ $errors->has('password') ? 'border-red-300 dark:border-red-700' : 'border-gray-200 dark:border-gray-700' }}
                                      focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent focus:bg-white dark:focus:bg-gray-700
                                      text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition-all">
                        <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <i :data-lucide="show ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div x-data="{ show: false }">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Confirm Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <i data-lucide="shield-check" class="w-4 h-4 text-gray-400"></i>
                        </div>
                        <input :type="show ? 'text' : 'password'"
                               id="password_confirmation"
                               name="password_confirmation"
                               required
                               placeholder="Repeat your password"
                               class="w-full pl-10 pr-10 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl
                                      focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent focus:bg-white dark:focus:bg-gray-700
                                      text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition-all">
                        <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <i :data-lucide="show ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-semibold text-sm rounded-xl
                               transition-all duration-200 shadow-sm hover:shadow-sky-200 dark:hover:shadow-sky-900 mt-2">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    Create Account
                </button>
            </form>
        </div>

        {{-- Sign In Link --}}
        <p class="text-center mt-6 text-sm text-gray-500 dark:text-gray-400">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-sky-600 dark:text-sky-400 hover:underline ml-1">
                Sign in
            </a>
        </p>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>