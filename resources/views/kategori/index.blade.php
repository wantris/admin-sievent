@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('kategorievent.add')}}" class="btn btn-primary mb-3">Tambah Kategori Event</a>
                    <table class="table table-bordered table-md" id="table-admin" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategoris as $kategori)
                            <tr id="tr_{{$kategori->id_kategori}}">
                                <td width="10%">{{$loop->iteration}}</td>
                                <td>{{$kategori->nama_kategori}}</td>
                                <td>
                                    <a href="{{route('kategorievent.edit', $kategori->id_kategori)}}"
                                        class="btn btn-secondary d-inline" title="Edit"><i class="fas fa-pen-square"></i></a>
                                    <a href="#" onclick="deleteKategori({{$kategori->id_kategori}})"
                                        class="btn btn-danger d-inline" title="Hapus"><i class="fas fa-trash-alt"></i></a>
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

    const deleteKategori = (id_kategori) => {
        let url = "/kategorievent/delete/"+id_kategori;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Kategori Event',
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
                            "id_kategori": id_kategori
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                $('#tr_' + id_kategori).remove();
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr);
                            Notiflix.Notify.Failure('Ooopss');
                        }
                });
            }, function(){
                 // No button callback alert('If you say so...'); 
            } ); 
    }
</script>
@endpush