@extends('app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <img id="banner-image" src="" style="width: 100%; height:300px;" alt="">
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('eventinternal.save')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('post')
                    <div class="form-group">
                        <label>Nama Ormawa</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <select class="form-control" required name="ormawa" id="">
                                <option selected>Pilih Ormawa</option>
                                @foreach ($ormawas as $ormawa)
                                <option value="{{$ormawa->id_ormawa}}">
                                    {{$ormawa->nama_ormawa}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('ormawa'))
                        <span class="text-danger">{{ $errors->first('ormawa') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Nama Event</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" required name="nama" class="form-control phone-number">
                        </div>
                        @if ($errors->has('nama'))
                        <span class="text-danger">{{ $errors->first('nama') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Kategori Event</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <select class="form-control" required name="kategori" id="">
                                <option selected>Pilih Kategori</option>
                                @foreach ($kategoris as $kategori)
                                <option value="{{$kategori->id_kategori}}">
                                    {{$kategori->nama_kategori}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('kategori'))
                        <span class="text-danger">{{ $errors->first('kategori') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Tipe Peserta</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <select class="form-control" required name="tipe_peserta" id="">
                                <option selected>Pilih Tipe Peserta</option>
                                @foreach ($tipes as $tipe)
                                <option value="{{$tipe->id_tipe_peserta}}">
                                    {{$tipe->nama_tipe}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('tipe_peserta'))
                        <span class="text-danger">{{ $errors->first('tipe_peserta') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Maksimal peserta</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" required name="maks" class="form-control phone-number">
                        </div>
                        @if ($errors->has('maks'))
                        <span class="text-danger">{{ $errors->first('maks') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" required name="role" class="form-control phone-number">
                        </div>
                        @if ($errors->has('role'))
                        <span class="text-danger">{{ $errors->first('role') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Tanggal Buka</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="date" required name="tgl_buka" class="form-control phone-number">
                        </div>
                        @if ($errors->has('tgl_buka'))
                        <span class="text-danger">{{ $errors->first('tgl_buka') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Tanggal Tutup</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="date" required name="tgl_tutup" class="form-control phone-number">
                        </div>
                        @if ($errors->has('tgl_tutup'))
                        <span class="text-danger">{{ $errors->first('tgl_tutup') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" required class="form-control"></textarea>

                        @if ($errors->has('deksripsi'))
                        <span class="text-danger">{{ $errors->first('deksripsi') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Ketentuan</label>
                        <textarea name="ketentuan" class="form-control"></textarea>

                    </div>
                    <div class="form-group">
                        <label>Poster</label>
                        <input type="file" accept="image/*" onchange="loadPhoto(event)" id="photo-inp" name="poster"
                            class="form-control" id="">
                        @if ($errors->has('poster'))
                        <span class="text-danger">{{ $errors->first('poster') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Banner</label>
                        <input type="file" name="banner" onchange="loadBanner(event)" class="form-control" id="">
                        @if ($errors->has('banner'))
                        <span class="text-danger">{{ $errors->first('banner') }}</span>
                        @endif
                    </div>
                    <input type="submit" value="Submit" class="btn btn-primary" style="width: 100%">
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="card">
            <div class="card-body">
                <img id="photo-image" src="" style="width:100%" alt="">
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    CKEDITOR.replace('deskripsi',{
      language:'en-gb'
    });
    CKEDITOR.replace('ketentuan',{
      language:'en-gb'
    });
    CKEDITOR.config.allowedContent = true;

    // display image Photo
    var loadPhoto = function(event) {
        var outputPhoto = document.getElementById('photo-image');
        outputPhoto.src = URL.createObjectURL(event.target.files[0]);
        outputPhoto.onload = function() {
        URL.revokeObjectURL(outputPhoto.src) // free memory
        }
    };

    var loadBanner = function(event) {
        var outputPhoto = document.getElementById('banner-image');
        outputPhoto.src = URL.createObjectURL(event.target.files[0]);
        outputPhoto.onload = function() {
        URL.revokeObjectURL(outputPhoto.src) // free memory
        }
    };
</script>
@endpush