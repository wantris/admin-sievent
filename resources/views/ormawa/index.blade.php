@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('ormawa.add')}}" class="btn btn-primary mb-4">Tambah Ormawa</a>
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
                                <a href="{{route('ormawa.detail', $ormawa->id_ormawa)}}"
                                    class="btn btn-primary d-inline-block mb-1" title="Detail"><i class="fas fa-eye"></i></a>
                                <a href="{{route('ormawa.edit', $ormawa->id_ormawa)}}"
                                    class="btn btn-secondary d-inline-block mb-1" title="Edit"><i class="fas fa-pen-square"></i></a>
                                <a href="#" onclick="deleteOrmawa({{$ormawa->id_ormawa}})"
                                    class="btn btn-danger d-inline-block mb-1" title="Hapus"><i class="fas fa-trash-alt"></i></a>
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
            responsive:"true"
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