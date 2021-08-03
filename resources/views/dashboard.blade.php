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
                    <h4>Total Partisipan</h4>
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
            <div class="card-icon bg-danger">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Dosen</h4>
                </div>
                <div class="card-body">
                    {{$dosens->count()}}
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
{{-- <div class="row">
    <div class="col-lg-12 col-md-6 col-12">
        <div class="card">
            <div class="card-body">
                <canvas id="canvas" height="280px" width="100%"></canvas>
            </div>
        </div>
    </div>
</div> --}}

@endsection

@push('script')
<script>
   


</script>
@endpush