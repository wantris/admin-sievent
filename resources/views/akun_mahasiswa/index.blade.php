@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('mahasiswa.add')}}" class="btn btn-primary mb-3">Tambah Akun Mahasiswa</a>
                <div class="table-responsive">
                    <table class="table table-bordered table-md" id="table-admin">
                        <thead>
                            <tr id="">
                                <th>No</th>
                                <th>Nama Mahasiswa</th>
                                <th>NIM</th>
                                <th>Nomor Telepon</th>
                                <th>Email</th>
                                <th>Photo</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mahasiswas as $mahasiswa)
                            <tr id="tr_{{$mahasiswa->nim}}">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$mahasiswa->nama_mahasiswa}}</td>
                                <td>{{$mahasiswa->nim}}</td>
                                <td>@if ($mahasiswa->phone)
                                    {{$mahasiswa->phone}}
                                    @endif

                                </td>
                                <td>@if ($mahasiswa->email)
                                    {{$mahasiswa->email}}
                                    @endif
                                </td>
                                <td>
                                    <img src="{{ env('BACKEND_ASSET_URL') . "assets/img/photo-pengguna/".$mahasiswa->photo}}"
                                        style="width: 50px; height:50px" alt="">
                                </td>
                                <td>{{$mahasiswa->created_at}}</td>
                                <td>
                                    <a href="{{route('mahasiswa.edit', $mahasiswa->nim)}}"
                                        class="btn btn-secondary d-inline">Edit</a>
                                    <a href="#" onclick="deleteMahasiswa({{$mahasiswa->nim}})"
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

    const deleteMahasiswa = (nim) => {
        console.log(nim);
        let url = "/mahasiswa/delete/"+nim;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Mahasiswa',
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
                            "nim": nim 
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                $('#tr_' + nim).remove();
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