@extends('layouts.app')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Dashboard</h1>
    </div>
    <hr>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div style="position: relative; height:40%; width:40%">
        <canvas id="userActivityChart"></canvas>
    </div>
    <script>
        var ctx = document.getElementById('userActivityChart').getContext('2d');

        @if (isset($userActivityCounts))
            var userActivityCounts = @json($userActivityCounts);
        @else
            var userActivityCounts = {
                insertionsCount: 0,
                softDeletesCount: 0
            };
        @endif

        var data = {
            labels: ['Insertions', 'Deletions'],
            datasets: [{
                data: [userActivityCounts.insertionsCount, userActivityCounts.softDeletesCount],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'doughnut',
            data: data,
        };

        var userActivityChart = new Chart(ctx, config);
    </script>
@endsection
