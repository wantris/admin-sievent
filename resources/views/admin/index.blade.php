@extends('app')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <a href="{{route('admin.add')}}" class="btn btn-primary mb-3">Tambah Admin</a>
        <div class="">
          <table class="table table-bordered table-md" id="table-admin">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($admins as $admin)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$admin->nama}}</td>
                <td>{{$admin->username}}</td>
                <td>{{$admin->created_at->isoFormat('D MMMM Y')}}</td>
                <td>
                    <div class="btn-group dropleft">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu dropdown-action">
                            <a class="dropdown-item dropdown-action-item" href="{{route('admin.edit', $admin->id_admin)}}"><i class="fas fa-pen-square mr-2"></i>Edit</a>
                        </div>
                    </div>
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