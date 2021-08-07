@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('blog.add')}}" class="btn btn-primary mb-4">Tambah blog</a>
                <div class="row mb-4">
                    <div class="col-lg-3 col-12">
                        <select id="status-select" class="form-control">
                            <option value="" selected>Semua Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </div>
                </div>
                <table class="table table-bordered table-md" id="table-admin" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Konten</th>
                            <th>Aktif?</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blogs as $blog)
                        <tr id="tr_{{$blog->id_blog}}">
                            <td width="5%">{{$loop->iteration}}</td>
                            <td>
                               {{$blog->title}}
                            </td>
                            <td>
                                @php
                                    $konten = Illuminate\Support\Str::limit($blog->konten, 25, $end='.......');
                                @endphp
                                {{$konten}}
                            </td>
                            <td>
                                @if ($blog->status == "1")
                                    Aktif
                                @else
                                    Tidak
                                @endif
                            </td>
                            @php
                                $created_at = \Carbon\Carbon::parse($blog->created_at);
                            @endphp
                            <td>{{$created_at->isoFormat('D MMMM Y')}}</td>
                            <td>
                                <div class="btn-group dropleft">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-action">
                                        @php
                                            $json_blog = json_encode($blog);
                                        @endphp
                                        <a class="dropdown-item dropdown-action-item" href="#" onclick="seeImage('{{$blog->image_url}}')"><i class="far fa-images mr-2"></i>Lihat Gambar</a>
                                        <a class="dropdown-item dropdown-action-item" href="{{route('blog.edit', $blog->slug)}}" ><i class="fas fa-pen-square mr-2"></i>Edit</a>
                                        <a class="dropdown-item dropdown-action-item"  onclick="deleteblog({{$blog->id_blog}})" href="#"><i class="fas fa-trash-alt mr-2"></i>Hapus</a>
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
{{-- Modal see image --}}
<div class="modal fade" id="blogModal" tabindex="1500" role="dialog" aria-labelledby="blogModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body" style="padding: 0 !important" id="modal-body-detail">
            <img src="" id="blog-image" class="img-fluid" alt="blog Image">
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
        });

        new $.fn.dataTable.FixedHeader( $dTable );
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const seeImage = (image_url) => {
        $('#blog-image').attr("src", image_url);
        $('#blogModal').modal('show');
        $("#blogModal").appendTo("body");
    }

    const deleteblog = (id_blog) => {
        let url = "/blog/delete/"+id_blog;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'blog',
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
                                $('#tr_' + id_blog).remove();
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