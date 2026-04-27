<!-- separate admin login page -->
 @extends('layouts.app')
@section('title', 'Admin Login')
@section('content')
<div class="max-w-md mx-auto card p-6 mt-12 border-amber-300 border-2">
    <h1 class="text-2xl font-bold mb-1">Admin Sign-in</h1>
    <p class="text-sm text-gray-500 mb-4">Restricted area.</p>
    <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">@csrf
        <div><label class="label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="input" required>
            @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div><label class="label">Password</label>
            <input type="password" name="password" class="input" required>
        </div>
        <button class="btn-primary w-full justify-center bg-amber-600 hover:bg-amber-700">Enter Admin</button>
    </form>
</div>
@endsection
