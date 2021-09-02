@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="#" onclick="addTestimoni()" class="btn btn-primary mb-4">Tambah Testimoni</a>
                <table class="table table-bordered table-md" id="table-admin" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Deskripsi</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testimonis as $testimoni)
                        <tr id="tr_{{$testimoni->id_testimoni}}">
                            <td>{{$loop->iteration}}</td>
                            <td>
                               {{$testimoni->name}}
                            </td>
                            <td>
                                {{$testimoni->role}}
                             </td>
                            <td>{{$testimoni->description}}</td>
                            @php
                                $created_at = \Carbon\Carbon::parse($testimoni->created_at);
                            @endphp
                            <td>{{$created_at->isoFormat('D MMMM Y')}}</td>
                            <td>
                                <div class="btn-group dropleft">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-action">
                                        @php
                                            $json_testimoni = json_encode($testimoni);
                                        @endphp
                                        <a class="dropdown-item dropdown-action-item" href="#" onclick="seeImage('{{$testimoni->image_url}}')"><i class="far fa-images mr-2"></i>Lihat Gambar</a>
                                        <a class="dropdown-item dropdown-action-item" href="#" onclick="updateTestimoni('{{$json_testimoni}}')"><i class="fas fa-pen-square mr-2"></i>Edit</a>
                                        <a class="dropdown-item dropdown-action-item"  onclick="deleteTestimoni({{$testimoni->id_testimoni}})" href="#"><i class="fas fa-trash-alt mr-2"></i>Hapus</a>
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

<!-- Modal -->
{{-- Modal see photo --}}
<div class="modal fade" id="testimoniModal" tabindex="1500" role="dialog" aria-labelledby="testimoniModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body" style="padding: 0 !important;" id="modal-body-detail">
            <img src="" id="testimoni-image" class="img-fluid" alt="testimoni Image">
        </div>
      </div>
    </div>
</div>

{{-- modal add testimoni --}}
<div class="modal fade" id="modalAddTestimoni" tabindex="-1" role="dialog" aria-labelledby="modalAddTestimoniLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddTestimoniLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" id="form-testimoni" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="">Nama</label>
                <input type="text" id="name-inp" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Role</label>
                <input type="text" id="role-inp" name="role" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Deskripsi</label>
                <textarea name="description" id="description-inp" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="">Photo</label>
                <input type="file" name="photo" id="photo-inp" class="form-control">
                <input type="hidden" id="old-photo-inp" name="old_photo">
            </div>
        </div>
        <div class="modal-footer">
            <input type="submit" value="Simpan" class="btn btn-primary">
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function () {
        var $dTable = $('#table-admin').DataTable({
            responsive:"true",
        });

        new $.fn.dataTable.FixedHeader( $dTable );
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const addTestimoni = () => {
        let url_form = "{{route('testimoni.save')}}";
        $('#modalAddTestimoniLabel').text('Tambah Testimoni');
        $('#form-testimoni').attr("action", url_form);
        $('#modalAddTestimoni').modal('show');
        $("#modalAddTestimoni").appendTo("body");
    }

    const updateTestimoni = (values) => {
        let testimoni = JSON.parse(values);
        let url_form = "/testimoni/update/"+testimoni.id_testimoni;

        $('#name-inp').val(testimoni.name);
        $('#role-inp').val(testimoni.role);
        $('#description-inp').text(testimoni.description);
        $('#old-photo-inp').val(testimoni.photo);
        $('#modalAddTestimoniLabel').text('Tambah Testimoni');
        $('#form-testimoni').attr("action", url_form);
        $('#modalAddTestimoni').modal('show');
        $("#modalAddTestimoni").appendTo("body");
    }

    const seeImage = (image_url) => {
        $('#testimoni-image').attr("src", image_url);
        $('#testimoniModal').modal('show');
        $("#testimoniModal").appendTo("body");
    }

    const deleteTestimoni = (id_testimoni) => {
        let url = "/testimoni/delete/"+id_testimoni;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Testimoni',
            'Apakah anda yakin ingin menghapus?',
            'Yes',
            'No',
             function(){ 
                $.ajax(
                    {
                        url: url,
                        type: 'get', 
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                $('#tr_' + id_testimoni).remove();
                            }else if(response.status == 0){
                                Notiflix.Notify.Success(response.message);
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