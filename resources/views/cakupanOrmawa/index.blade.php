@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('cakupanOrmawa.add')}}" class="btn btn-primary mb-5">Tambah Cakupan Ormawa</a>
                    <table class="table table-bordered table-md" id="table-admin" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ormawa</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cakupans as $cakupan)
                            <tr id="tr_{{$cakupan->id_cakupan_ormawa}}">
                                <td width="10%">{{$loop->iteration}}</td>
                                <td>
                                    @if ($cakupan->ormawa_id)
                                    {{$cakupan->ormawaRef->nama_ormawa}}
                                    @endif
                                </td>
                                <td>
                                    {{$cakupan->role}}
                                </td>
                                <td>
                                    <div class="btn-group dropleft">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu dropdown-action">
                                            <a class="dropdown-item dropdown-action-item" href="{{route('cakupanOrmawa.edit', $cakupan->id_cakupan_ormawa)}}"><i class="fas fa-pen-square mr-2"></i>Edit</a>
                                            <a class="dropdown-item dropdown-action-item" onclick="deleteCakupan({{$cakupan->id_cakupan_ormawa}})" href="#"><i class="fas fa-trash-alt mr-2"></i>Hapus</a>
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
            responsive:"true"
        });

        new $.fn.dataTable.FixedHeader( $dTable );
    });

    const deleteCakupan = (id_cakupan) => {
        let url = "/cakupanormawa/delete/"+id_cakupan;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Cakupan Ormawa',
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
                            "id_cakupanOrmawa": id_cakupan 
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                $('#tr_' + id_cakupan).remove();
                            }
                        },
                        error: function(xhr) {
                            Notiflix.Notify.Failure('Oopss');
                        }
                });
            }, function(){
                 // No button callback alert('If you say so...'); 
            } ); 
    }
</script>
@endpush