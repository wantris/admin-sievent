@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('wadir3.add')}}" class="btn btn-primary mb-3">Tambah Wakil Direktur 3</a>
                <div class="">
                    <table class="table table-bordered table-md" id="table-admin">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nidn</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wadir3s as $wadir3)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$wadir3->nama_dosen}}</td>
                                <td>{{$wadir3->nidn}}</td>
                                <td>
                                    @if ($wadir3->status == "1")
                                    <button disabled="disabled" class="btn btn-primary">Aktif</button>
                                    @else
                                    <button disabled="disabled" class="btn btn-danger">Tidak Aktif</button>
                                    @endif
                                </td>
                                <td>{{$wadir3->created_at->isoFormat('D MMMM Y')}}</td>
                                <td>
                                    <a href="{{route('wadir3.edit', $wadir3->id_wadir3)}}"
                                        class="btn btn-secondary d-inline">Edit</a>
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