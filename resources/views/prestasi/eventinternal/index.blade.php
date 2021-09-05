@extends('app')

@section('content')
<div class="row mb-4">
    <div class="col-lg-3 col-12 col-md-4">
        <div class="card rounded">
            <div class="card-body">
                <div class="mb-3 py-5" style="position: relative" >
                    <img src="{{asset('assets/icons/all-prodi.svg')}}" class="mx-auto center-fix" width="60" alt="">
                </div>
                <div class="text-center">
                    <p class="font-weight-bold text-secondary">Semua Jurusan</p>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <a href="#" class="btn btn-primary btn-block">PDF</a>
                    </div>
                    <div class="col-lg-6 col-12">
                        <a href="{{route('prestasi.eventinternal.excel.all')}}" class="btn btn-success btn-block">Excel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    

</script>
@endpush