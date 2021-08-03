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
                                    <a href="{{route('tipepeserta.edit', $tp->id_tipe_peserta)}}"
                                        class="btn btn-secondary d-inline-block mb-1" title="Edit"><i class="fas fa-pen-square"></i></a>
                                    <a href="#" onclick="deleteTipe({{$tp->id_tipe_peserta}})"
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