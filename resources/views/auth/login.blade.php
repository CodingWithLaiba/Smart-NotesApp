@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white dark:bg-gray-800 p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">Login</h2>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
        @csrf

        <div>
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600" />
        </div>

        <div>
            <label class="block text-sm mb-1">Password</label>
            <input type="password" name="password" required
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600" />
        </div>

        <div class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="remember" id="remember" />
            <label for="remember">Remember me</label>
        </div>

        <button type="submit" class="bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Login
        </button>
    </form>

    <p class="text-sm mt-4 text-center">
        No account? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register</a>
    </p>

</div>
@endsection