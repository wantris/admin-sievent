@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('pembina.add')}}" class="btn btn-primary mb-4">Tambah Pembina</a>
                <div class="row mb-4">
                    <div class="col-lg-3 col-12">
                        <select name="" id="ormawa-select" class="form-control">
                            <option value="">Semua Ormawa</option>
                            @foreach ($ormawas as $ormawa)
                                <option value="{{$ormawa}}">{{$ormawa}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <table class="table table-bordered table-md" id="table-admin" style="width: 100%">
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
                            <td>
                                @if ($pembina->dosenRef)
                                    {{$pembina->dosenRef->dosen_lengkap_nama}}
                                @endif
                            </td>
                            <td>{{$pembina->ormawaRef->nama_ormawa}}</td>
                            <td>{{$pembina->tahun_jabatan}}</td>
                            <td>
                                @if ($pembina->status == "1")
                                <button disabled="disabled" class="btn btn-primary">Aktif</button>
                                @else
                                <button disabled="disabled" class="btn btn-danger">Tidak Aktif</button>
                                @endif
                            </td>
                            <td>{{$pembina->created_at->isoFormat('D MMMM Y')}}</td>
                            <td>
                                <div class="btn-group dropleft">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-action">
                                        <a class="dropdown-item dropdown-action-item" href="{{route('pembina.edit', $pembina->id_pembina)}}"><i class="fas fa-pen-square mr-2"></i>Edit</a>
                                        <a class="dropdown-item dropdown-action-item"  onclick="deletePembina({{$pembina->id_pembina}})" href="#"><i class="fas fa-trash-alt mr-2"></i>Hapus</a>
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
    $(document).ready(function () {
        var $dTable = $('#table-admin').DataTable({
            responsive:"true",
            dom: 'Bfrtip',
            buttons: [    
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                        className:'btnExcel',
                        customize: function ( xlsx ) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('c[r=A1] t', sheet).text( 'Data Pembina');
                            $('row:first c', sheet).attr( 's', '51', '2' ); // first row is bold
                        }
                    }
                ],
        });

        new $.fn.dataTable.FixedHeader( $dTable );
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