@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="#" onclick="addSlider()" class="btn btn-primary mb-4">Tambah Slider</a>
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
                            <th>Deskripsi</th>
                            <th>Aktif?</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sliders as $slider)
                        <tr id="tr_{{$slider->id_slider}}">
                            <td>{{$loop->iteration}}</td>
                            <td>
                               {{$slider->title}}
                            </td>
                            <td>{{$slider->deskripsi}}</td>
                            <td>
                                @if ($slider->is_active == "1")
                                    Aktif
                                @else
                                    Tidak
                                @endif
                            </td>
                            @php
                                $created_at = \Carbon\Carbon::parse($slider->created_at);
                            @endphp
                            <td>{{$created_at->isoFormat('D MMMM Y')}}</td>
                            <td>
                                <div class="btn-group dropleft">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-action">
                                        @php
                                            $json_slider = json_encode($slider);
                                        @endphp
                                        <a class="dropdown-item dropdown-action-item" href="#" onclick="seeImage('{{$slider->image_url}}')"><i class="far fa-images mr-2"></i>Lihat Gambar</a>
                                        <a class="dropdown-item dropdown-action-item" href="#" onclick="updateSlider('{{$json_slider}}')"><i class="fas fa-pen-square mr-2"></i>Edit</a>
                                        <a class="dropdown-item dropdown-action-item"  onclick="deleteSlider({{$slider->id_slider}})" href="#"><i class="fas fa-trash-alt mr-2"></i>Hapus</a>
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
<div class="modal fade" id="sliderModal" tabindex="1500" role="dialog" aria-labelledby="sliderModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body" style="padding: 0 !important" id="modal-body-detail">
            <img src="" id="slider-image" class="img-fluid" alt="Slider Image">
        </div>
      </div>
    </div>
</div>

{{-- modal add slider --}}
<div class="modal fade" id="modalAddSlider" tabindex="-1" role="dialog" aria-labelledby="modalAddSliderLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddSliderLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" id="form-slider" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="">Judul</label>
                <input type="text" id="title-inp" name="title" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Deskripsi</label>
                <textarea name="description" id="description-inp" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="">Gambar Slider</label>
                <input type="file" name="image" id="image-inp" class="form-control">
                <input type="hidden" id="old-image-inp" name="old_image">
            </div>
            <div class="form-group">
                <div class="control-label">Status Slider</div>
                <label class="custom-switch mt-2" style="margin-left: -7% !important">
                <input type="checkbox" value="1" name="is_active" id="status-inp" class="custom-switch-input">
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">Aktif</span>
                </label>
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

    const addSlider = () => {
        let url_form = "{{route('slider.save')}}";
        $('#modalAddSliderLabel').text('Tambah Slider');
        $('#form-slider').attr("action", url_form);
        $('#modalAddSlider').modal('show');
        $("#modalAddSlider").appendTo("body");
    }

    const updateSlider = (values) => {
        let slider = JSON.parse(values);
        let url_form = "/slider/update/"+slider.id_slider;

        $('#title-inp').val(slider.title);
        $('#description-inp').text(slider.deskripsi);
        $('#old-image-inp').val(slider.image_name);
        if(slider.is_active == 1){
            $('#status-inp').val(slider.is_active);
            $('.custom-switch-input').prop("checked", true);
        }
        $('#modalAddSliderLabel').text('Tambah Slider');
        $('#form-slider').attr("action", url_form);
        $('#modalAddSlider').modal('show');
        $("#modalAddSlider").appendTo("body");
    }

    const seeImage = (image_url) => {
        $('#slider-image').attr("src", image_url);
        $('#sliderModal').modal('show');
        $("#sliderModal").appendTo("body");
    }

    const deleteSlider = (id_slider) => {
        let url = "/slider/delete/"+id_slider;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Slider',
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
                                $('#tr_' + id_slider).remove();
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