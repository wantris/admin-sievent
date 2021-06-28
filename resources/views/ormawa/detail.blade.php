@extends('app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <img id="banner-image" src="{{ env('BACKEND_ASSET_URL') . "assets/img/banner-ormawa/$ormawa->banner"}}"
                    style="width: 100%; height:300px;" alt="">
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('ormawa.update', $id_ormawa)}}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label>Nama Ormawa</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" required name="nama" disabled value="{{$ormawa->nama_ormawa}}"
                                class="form-control phone-number">
                        </div>
                        @if ($errors->has('nama'))
                        <span class="text-danger">{{ $errors->first('nama') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Nama Akronim</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" disabled value="{{$ormawa->nama_akronim}}" name="akronim"
                                class="form-control phone-number">
                        </div>
                        @if ($errors->has('akronim'))
                        <span class="text-danger">{{ $errors->first('akronim') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" required disabled value="{{$ormawa->username}}" name="username"
                                class="form-control phone-number">
                        </div>
                        @if ($errors->has('username'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-key"></i>
                                </div>
                            </div>
                            <input type="text" name="email" disabled value="{{$ormawa->email}}"
                                class="form-control phone-number">
                        </div>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Website</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-key"></i>
                                </div>
                            </div>
                            <input type="text" name="website" disabled value="{{$ormawa->website}}"
                                class="form-control phone-number">
                        </div>
                        @if ($errors->has('website'))
                        <span class="text-danger">{{ $errors->first('website') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea id="deskripsi" class="form-control" disabled name="deksripsi" rows="10"
                            cols="50">{{$ormawa->deskripsi}}</textarea>
                        @if ($errors->has('website'))
                        <span class="text-danger">{{ $errors->first('website') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" accept="image/*" onchange="loadPhoto(event)" id="photo-inp" name="photo"
                            class="form-control" id="">
                        @if ($errors->has('website'))
                        <span class="text-danger">{{ $errors->first('website') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Banner</label>
                        <input type="file" name="banner" onchange="loadBanner(event)" class="form-control" id="">
                        @if ($errors->has('website'))
                        <span class="text-danger">{{ $errors->first('website') }}</span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="card">
            <div class="card-body">
                <img id="photo-image" src="{{ env('BACKEND_ASSET_URL') . "assets/img/ormawa-logo/$ormawa->photo"}}"
                    style="width:100%" alt="">
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
    CKEDITOR.config.allowedContent = true;

</script>
@endpush