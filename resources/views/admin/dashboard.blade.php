@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
    <div class="card p-6 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-500/10 rounded-full"></div>
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Users</p>
                <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ $totalUsers }}</p>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">All registered accounts</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <div class="card p-6 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-32 h-32 bg-purple-500/10 rounded-full"></div>
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Notes</p>
                <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ $totalNotes }}</p>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $activeNotes }} active (not deleted)</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                <i data-lucide="file-text" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <div class="card p-6 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-32 h-32 bg-emerald-500/10 rounded-full"></div>
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Categories</p>
                <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ $totalCategories }}</p>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Total categories</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                <i data-lucide="folder" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <div class="card p-6 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-32 h-32 bg-amber-500/10 rounded-full"></div>
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tags</p>
                <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ $totalTags }}</p>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Total tags</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                <i data-lucide="tag" class="w-5 h-5"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <div class="card p-6 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-semibold text-gray-900 dark:text-white">Activity</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Notes created in the last 7 days</p>
            </div>
            <span class="text-xs px-2 py-1 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-800">
                Total: {{ $notesPerDay->sum('count') }}
            </span>
        </div>
        <canvas id="notesChart" height="120"></canvas>
    </div>

    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-semibold text-gray-900 dark:text-white">Overview</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">System distribution</p>
            </div>
        </div>
        <div class="flex items-center justify-center">
            <div class="w-full max-w-xs">
                <canvas id="overviewDonut" height="220"></canvas>
            </div>
        </div>
        <div class="mt-4 grid grid-cols-2 gap-2 text-sm">
            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Users</div>
            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span> Notes</div>
            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Categories</div>
            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Tags</div>
        </div>
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-2 mt-6">
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-semibold text-gray-900 dark:text-white">Recent users</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Latest registrations</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">View all</a>
        </div>
        <ul class="divide-y divide-gray-100 dark:divide-gray-800">
            @foreach($recentUsers as $u)
                <li class="py-3 flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <p class="font-medium text-gray-900 dark:text-white truncate">{{ $u->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $u->email }}</p>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                        {{ optional($u->created_at)->diffForHumans() ?? '—' }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-semibold text-gray-900 dark:text-white">Recent notes</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Latest created notes</p>
            </div>
            <a href="{{ route('admin.notes.index') }}" class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline">View all</a>
        </div>
        <ul class="divide-y divide-gray-100 dark:divide-gray-800">
            @foreach($recentNotes as $n)
                <li class="py-3 flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <p class="font-medium text-gray-900 dark:text-white truncate">{{ $n->title }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                            by {{ $n->user->name ?? '—' }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2 whitespace-nowrap">
                        <a href="{{ route('admin.notes.show', $n) }}" class="text-xs px-2 py-1 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                            View
                        </a>
                        <form method="POST" action="{{ route('admin.notes.destroy', $n) }}" onsubmit="return confirm('Delete this note?')">
                            @csrf @method('DELETE')
                            <button class="text-xs px-2 py-1 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-900/30">
                                Delete
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const notesLabels = @json($notesPerDay->pluck('date'));
        const notesData = @json($notesPerDay->pluck('count'));

        const notesCtx = document.getElementById('notesChart').getContext('2d');
        new Chart(notesCtx, {
            type: 'line',
            data: {
                labels: notesLabels,
                datasets: [{
                    label: 'Notes Created',
                    data: notesData,
                    borderColor: 'rgba(99, 102, 241, 1)', // indigo-500-ish
                    backgroundColor: 'rgba(99, 102, 241, 0.15)',
                    fill: true,
                    tension: 0.35,
                    pointRadius: 2,
                    pointHoverRadius: 4,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });

        const donutCtx = document.getElementById('overviewDonut').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Users', 'Notes', 'Categories', 'Tags'],
                datasets: [{
    data: {!! json_encode([$totalUsers, $totalNotes, $totalCategories, $totalTags]) !!},
    backgroundColor: [
        'rgba(59, 130, 246, 0.9)',
        'rgba(168, 85, 247, 0.9)',
        'rgba(16, 185, 129, 0.9)',
        'rgba(245, 158, 11, 0.9)',
    ],
    borderWidth: 0,
    hoverOffset: 6,
}]
            },
            options: {
                cutout: '65%',
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: (ctx) => ` ${ctx.label}: ${ctx.parsed}` } }
                }
            }
        });
    </script>
@endpush