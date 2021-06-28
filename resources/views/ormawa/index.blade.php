@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('ormawa.add')}}" class="btn btn-primary mb-3">Tambah Ormawa</a>
                <div class="table-responsive">
                    <table class="table table-bordered table-md" id="table-admin">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ormawa</th>
                                <th>Nama Akronim</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ormawas as $ormawa)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$ormawa->nama_ormawa}}</td>
                                <td>{{$ormawa->nama_akronim}}</td>
                                <td>{{$ormawa->username}}</td>
                                <td>{{$ormawa->email}}</td>
                                <td>{{$ormawa->created_at}}</td>
                                <td>
                                    <a href="{{route('ormawa.detail', $ormawa->id_ormawa)}}"
                                        class="btn btn-primary mt-2 d-inline">Detail</a>
                                    <a href="{{route('ormawa.edit', $ormawa->id_ormawa)}}"
                                        class="btn btn-secondary mt-2 d-inline">Edit</a>
                                    <a href="{{route('ormawa.delete', $ormawa->id_ormawa)}}"
                                        class="btn btn-danger mt-2 d-inline">Hapus</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function () {
      $('#table-admin').DataTable();
    });
</script>
@endpush