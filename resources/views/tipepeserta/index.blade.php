@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('tipepeserta.add')}}" class="btn btn-primary mb-4">Tambah Tipe Peserta</a>
                <div class="">
                    <table class="table table-bordered table-md" id="table-admin" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tipe</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tps as $tp)
                            <tr id="tr_{{$tp->id_tipe_peserta}}">
                                <td width="5%">{{$loop->iteration}}</td>
                                <td>{{$tp->nama_tipe}}</td>
                                <td>
                                    <div class="btn-group dropleft">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu dropdown-action">
                                            <a class="dropdown-item dropdown-action-item" href="{{route('tipepeserta.edit', $tp->id_tipe_peserta)}}"><i class="fas fa-pen-square mr-2"></i>Edit</a>
                                            <a class="dropdown-item dropdown-action-item" onclick="deleteTipe({{$tp->id_tipe_peserta}})" href="#"><i class="fas fa-trash-alt mr-2"></i>Hapus</a>
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

    const deleteTipe = (id) => {
        let url = "/tipepeserta/delete/"+id;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Tipe Peserta',
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
                            "id_tipepeserta": id 
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                $('#tr_' + id).remove();
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