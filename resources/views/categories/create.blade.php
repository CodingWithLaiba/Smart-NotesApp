<!-- create new category -->
 @extends('layouts.app')
@section('title', 'New Category')
@section('content')
<div class="max-w-md mx-auto card p-6">
    <h1 class="text-2xl font-bold mb-4">New Category</h1>
    <form method="POST" action="{{ route('categories.store') }}" class="space-y-4">@csrf
        <div><label class="label">Name</label><input name="name" class="input" required autofocus></div>
        <button class="btn-primary">Create</button>
    </form>
</div>
@endsection
