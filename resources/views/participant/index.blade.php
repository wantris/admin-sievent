@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('participant.add')}}" class="btn btn-primary mb-3">Tambah Participant</a>
                <div class="table-responsive">
                    <table class="table table-bordered table-md" id="table-admin">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Participant</th>
                                <th>Nomor Telepon</th>
                                <th>Email</th>
                                <th>Photo</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($participants as $participant)
                            <tr id="tr_{{$participant->id_participant}}">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$participant->nama_participant}}</td>
                                <td>@if ($participant->pengguna_ref->phone)
                                    {{$participant->pengguna_ref->phone}}
                                    @endif

                                </td>
                                <td>@if ($participant->pengguna_ref->email)
                                    {{$participant->pengguna_ref->email}}
                                    @endif
                                </td>
                                <td>
                                    <img src="{{ env('BACKEND_ASSET_URL') . "assets/img/photo-pengguna/".$participant->pengguna_ref->photo}}"
                                        style="width: 50px; height:50px" alt="">
                                </td>
                                <td>{{$participant->created_at}}</td>
                                <td>
                                    <a href="{{route('participant.edit', $participant->id_participant)}}"
                                        class="btn btn-secondary d-inline">Edit</a>
                                    <a href="#" onclick="deleteParticipant({{$participant->id_participant}})"
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

    const deleteParticipant = (id_participant) => {
        let url = "/participant/delete/"+id_participant;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'participant',
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
                            "id_participant": id_participant 
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                $('#tr_' + id_participant).remove();
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