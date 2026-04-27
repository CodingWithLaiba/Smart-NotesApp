<!-- stats: users, notes, charts -->
 @extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="grid md:grid-cols-3 gap-4 mb-6">
    <div class="card p-6"><div class="text-sm text-gray-500">Total Users</div><div class="text-3xl font-bold">{{ $totalUsers }}</div></div>
    <div class="card p-6"><div class="text-sm text-gray-500">Total Notes</div><div class="text-3xl font-bold">{{ $totalNotes }}</div></div>
    <div class="card p-6"><div class="text-sm text-gray-500">Last 14 days</div><div class="text-3xl font-bold">{{ $notesPerDay->sum('total') }}</div></div>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="card p-6">
        <h2 class="font-semibold mb-3">Recent users</h2>
        <ul class="divide-y">
            @foreach($recentUsers as $u)
                <li class="py-2 flex justify-between text-sm">
                    <span>{{ $u->name }} <span class="text-gray-500">({{ $u->email }})</span></span>
                    <span class="text-gray-500">{{ $u->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="card p-6">
        <h2 class="font-semibold mb-3">Notes per day</h2>
        <canvas id="notesChart" height="160"></canvas>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
    const labels = @json($notesPerDay->pluck('date'));
    const data = @json($notesPerDay->pluck('total'));

    const ctx = document.getElementById('notesChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Notes Created',
                data: data,
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
    </div>
</div>
@endsection
