@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fas fa-portrait"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Admin</h4>
                </div>
                <div class="card-body">
                    {{$admin->count()}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-sitemap"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Ormawa</h4>
                </div>
                <div class="card-body">
                    {{$ormawa->count()}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-id-badge"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total participant</h4>
                </div>
                <div class="card-body">
                    {{$ps->count()}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Mahasiswa</h4>
                </div>
                <div class="card-body">
                    {{$mhs->count()}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-dark">
                <i class="fas fa-calendar-week"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Event Internal</h4>
                </div>
                <div class="card-body">
                    {{$ei->count()}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-calendar-minus"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Event Eksternal</h4>
                </div>
                <div class="card-body">
                    {{$ee->count()}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Pembina</h4>
                </div>
                <div class="card-body">
                    {{$pembina->count()}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Tim</h4>
                </div>
                <div class="card-body">
                    {{$tim->count()}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-dark">
                <i class="fas fa-id-card-alt"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Pendaftar Event Internal</h4>
                </div>
                <div class="card-body">
                    {{$eir->count()}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-info">
                <i class="fas fa-id-card-alt"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Pendaftar Event Eksternal</h4>
                </div>
                <div class="card-body">
                    {{$eer->count()}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-6 col-12">
        <div class="card">
            <div class="card-body">
                <canvas id="canvas" height="280px" width="100%"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    var year = '{{$year}}';
    console.log(year);
    var participants = '{{$participants}}';

    const labels = ['januari', 'februari','maret','april','mei'];
    const data = {
            labels: labels,
            datasets: [{
                label: 'My First Dataset',
                data: [65, 59, 80, 81, 56],
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)'
                ],
            borderColor: [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)'
            ],
            borderWidth: 1
        }]
    };

    var ctx = document.getElementById("canvas").getContext("2d");
    const config = new Chart(ctx,{
            type: 'bar',
            data: data,
            options: {
                scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    });


    // var barChartData = {
    //     labels: year,
    //     datasets: [{
    //         label: 'Participant',
    //         backgroundColor: "pink",
    //         data: participants
    //     }]
    // };

    // window.onload = function() {

    

    // window.myBar = new Chart(ctx, {
    //     type: 'bar',
    //     data: barChartData,
    //     options: {
    //         elements: {
    //             rectangle: {
    //                 borderWidth: 2,
    //                 borderColor: '#c1c1c1',
    //                 borderSkipped: 'bottom'
    //             }
    //         },
    //         responsive: true,
    //         title: {
    //             display: true,
    //             text: 'Yearly Participant Joined'
    //         }
    //     }
    // });
    // };


</script>
@endpush