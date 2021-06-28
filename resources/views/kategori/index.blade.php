@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('kategorievent.add')}}" class="btn btn-primary mb-3">Tambah Kategori Event</a>
                <div class="">
                    <table class="table table-bordered table-md" id="table-admin">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategoris as $kategori)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$kategori->nama_kategori}}</td>
                                <td>
                                    <a href="{{route('kategorievent.edit', $kategori->id_kategori)}}"
                                        class="btn btn-secondary d-inline">Edit</a>
                                    <a href="{{route('kategorievent.delete', $kategori->id_kategori)}}"
                                        class="btn btn-danger d-inline">Hapus</a>
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