@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('pembina.add')}}" class="btn btn-primary mb-3">Tambah Pembina</a>
                <div class="table-responsive">
                    <table class="table table-bordered table-md" id="table-admin">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Dosen</th>
                                <th>Ormawa</th>
                                <th>Tahun Jabatan</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembinas as $pembina)
                            <tr id="tr_{{$pembina->id_pembina}}">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$pembina->nama_dosen}}</td>
                                <td>{{$pembina->ormawaRef->nama_ormawa}}</td>
                                <td>{{$pembina->periode}}</td>
                                <td>
                                    @if ($pembina->status == "1")
                                    <button disabled="disabled" class="btn btn-primary">Aktif</button>
                                    @else
                                    <button disabled="disabled" class="btn btn-danger">Tidak Aktif</button>
                                    @endif
                                </td>
                                <td>{{$pembina->created_at->isoFormat('D MMMM Y')}}</td>
                                <td>
                                    <a href="{{route('pembina.edit', $pembina->id_pembina)}}"
                                        class="btn btn-secondary d-inline">Edit</a>
                                    <a href="#" onclick="deletePembina({{$pembina->id_pembina}})"
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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const deletePembina = (id_pembina) => {
        let url = "/pembina/delete/"+id_pembina;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'pembina',
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
                            "id_pembina": id_pembina 
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                $('#tr_' + id_pembina).remove();
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