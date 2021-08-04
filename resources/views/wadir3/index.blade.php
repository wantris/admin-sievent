@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-12">
                       <div class="d-flex">
                        <a href="{{route('wadir3.add')}}" class="btn btn-primary mr-2">Tambah Wakil Direktur 3</a>
                        <a href="{{route('wadir3.export')}}" class="btn btn-success">Excel</a>
                       </div>
                    </div>
                </div>
                <div class="">
                    <table class="table table-bordered table-md" id="table-admin" style="width: 100%" cellspacing="0">
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
                            <tr id="tr_{{$wadir3->id_wadir3}}">
                                <td>{{$loop->iteration}}</td>
                                <td>{{ucwords($wadir3->dosenRef->dosen_nama)}}</td>
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
                                    <div class="btn-group dropleft">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu dropdown-action">
                                            <a class="dropdown-item dropdown-action-item" href="{{route('wadir3.edit', $wadir3->id_wadir3)}}"><i class="fas fa-pen-square mr-2"></i>Edit</a>
                                            <a class="dropdown-item dropdown-action-item" onclick="deleteWadir({{$wadir3->id_wadir3}})" href="#"><i class="fas fa-trash-alt mr-2"></i>Hapus</a>
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
      var table = $('#table-admin').DataTable({
        responsive: true,
      });
      new $.fn.dataTable.FixedHeader( table );
    });

    
    const deleteWadir = (id_wadir3) => {
        console.log(id_wadir3);
        let url = "/wadir3/delete/"+id_wadir3;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'wadir3',
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
                            "id_wadir3": id_wadir3 
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                $('#tr_' + id_wadir3).remove();
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