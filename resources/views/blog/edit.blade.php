@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-8 col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 text-right">
                        <a href="{{route('blog.index')}}" class="btn btn-primary">Kembali</a>
                    </div>
                </div>
                <form action="{{route('blog.update', $blog->id_blog)}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Judul</label>
                        <input type="text" id="title-inp" value="{{ $blog->title }}" name="title" class="form-control">
                        @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Konten</label>
                        <textarea name="konten" id="konten-inp"  class="form-control">{{ $blog->konten }}</textarea>
                        @if ($errors->has('konten'))
                            <span class="text-danger">{{ $errors->first('konten') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Gambar Blog</label>
                        <input type="file" name="image" onchange="loadPhoto(event)"  id="image-inp" class="form-control">
                        <input type="hidden" name="old_image" value="{{$blog->image_name}}">
                        @if ($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('image') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="control-label">Status Blog</div>
                        <label class="custom-switch mt-2" style="margin-left: -4% !important">
                        <input type="checkbox" value="1" @if($blog->status == 1) checked @endif name="is_active" id="status-inp" class="custom-switch-input">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Aktif</span>
                        </label>
                    </div>
                    <input type="submit" value="Submit" class="btn btn-primary" style="width: 100%">
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="card">
            <div class="card-body">
                <img src="{{$blog->image_url}}" class="img-fluid" id="photo-image" alt="">
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    CKEDITOR.replace('konten-inp',{
        language:'en-gb'
    });

    // display image Photo
    var loadPhoto = function(event) {
        var outputPhoto = document.getElementById('photo-image');
        outputPhoto.src = URL.createObjectURL(event.target.files[0]);
        outputPhoto.onload = function() {
        URL.revokeObjectURL(outputPhoto.src) // free memory
        }
    };
</script>
@endpush

