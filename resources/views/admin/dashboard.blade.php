@extends('layouts.admin')
@section('content')
<div class="p-6">
    <h1 class="text-3xl mb-4">Admin Dashboard</h1>
    <div class="grid md:grid-cols-2 gap-4">
        <canvas id="loansChart"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Bar chart for loans by status
        new Chart(document.getElementById('loansChart'), { type: 'bar', data: { labels: ['Pending', 'Approved'], datasets: [{ data: [12, 45] }] } });
    </script>
</div>
@endsection
