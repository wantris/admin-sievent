@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="d-flex col-12">
                        <a href="{{route('ormawa.add')}}" class="btn btn-primary mr-2">Tambah Ormawa</a>
                        <a href="{{route('ormawa.export')}}" class="btn btn-success">Excel</a>
                    </div>
                </div>
                <table class="table table-bordered table-md" id="table-admin" style="width: 100%">
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
                        <tr id="tr_{{$ormawa->id_ormawa}}">
                            <td width="5%">{{$loop->iteration}}</td>
                            <td width="25%">{{$ormawa->nama_ormawa}}</td>
                            <td width="15%">{{$ormawa->nama_akronim}}</td>
                            <td>{{$ormawa->username}}</td>
                            <td>{{$ormawa->email}}</td>
                            <td>{{$ormawa->created_at}}</td>
                            <td width="25%">
                                <div class="btn-group dropleft">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-action">
                                        <a class="dropdown-item dropdown-action-item" href="{{route('ormawa.detail', $ormawa->id_ormawa)}}"><i class="fas fa-eye mr-2"></i>Detail</a>
                                        <a class="dropdown-item dropdown-action-item" href="{{route('ormawa.edit', $ormawa->id_ormawa)}}"><i class="fas fa-pen-square mr-2"></i>Edit</a>
                                        <a class="dropdown-item dropdown-action-item" onclick="deleteOrmawa({{$ormawa->id_ormawa}})" href="#"><i class="fas fa-trash-alt mr-2"></i>Hapus</a>
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
@endsection

@push('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {
        var $dTable = $('#table-admin').DataTable({
            responsive:"true",
            "lengthChange": false,
        });

        new $.fn.dataTable.FixedHeader( $dTable );
    });

    const deleteOrmawa = (id_ormawa) => {
        let url = "/ormawa/delete/"+id_ormawa;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Ormawa',
            'Apakah anda yakin ingin menghapus?',
            'Yes',
            'No',
             function(){ 
                $.ajax(
                    {
                        url: url,
                        type: 'delete', 
                        dataType: "JSON",
                        data: {
                            "id_ormawa": id_ormawa 
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                $('#tr_' + id_ormawa).remove();
                            }
                        },
                        error: function(xhr) {
                            Notiflix.Notify.Failure('Ooopss');
                        }
                });
            }, function(){
                 // No button callback alert('If you say so...'); 
            } ); 
    }
</script>
@endpush