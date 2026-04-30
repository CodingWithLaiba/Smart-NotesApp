@extends('layouts.auth')
@section('title', 'Admin Sign In')

@section('heading')
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Admin sign in</h1>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Restricted area</p>
@endsection

@section('content')
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

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
        @csrf
        <div>
            <label class="label" for="email">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                    <i data-lucide="mail" class="w-4 h-4 text-gray-400"></i>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="input pl-10" required autofocus>
            </div>
        </div>
        <div x-data="{ show: false }">
            <label class="label" for="password">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                    <i data-lucide="lock" class="w-4 h-4 text-gray-400"></i>
                </div>
                <input :type="show ? 'text' : 'password'" id="password" name="password" class="input pl-10 pr-10" required>
                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i :data-lucide="show ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        <div class="flex items-center justify-between text-sm">
            <label class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-300">
                <input type="checkbox" name="remember" class="rounded border-gray-300 dark:border-gray-700">
                Remember me
            </label>
            <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline">User login</a>
        </div>
        <button class="btn-primary w-full justify-center !bg-gradient-to-r !from-amber-600 !to-orange-600 hover:!from-amber-700 hover:!to-orange-700">
            <i data-lucide="shield" class="w-4 h-4"></i>
            Enter Admin
        </button>
    </form>

    <p class="text-center mt-6 text-sm text-gray-500 dark:text-gray-400">
        Need an admin account?
        <a href="{{ route('admin.register') }}" class="font-medium text-amber-600 dark:text-amber-400 hover:underline ml-1">Register</a>
    </p>
@endsection
