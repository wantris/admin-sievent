@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('mahasiswa.update', $pengguna->nim)}}" enctype="multipart/form-data"
                    method="post">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label>Nama Mahasiswa</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" value="{{$mhs->nama}}" disabled class="form-control phone-number">
                        </div>
                        @if ($errors->has('nama'))
                        <span class="text-danger">{{ $errors->first('nama') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Nim</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" value="{{$mhs->nim}}" disabled class="form-control phone-number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" required value="{{$pengguna->username}}" name="username"
                                class="form-control phone-number">
                        </div>
                        @if ($errors->has('username'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" name="newPassword" class="form-control phone-number">
                            <input type="hidden" name="oldPassword" value="{{$pengguna->password}}">
                            <input type="hidden" name="oldPhoto" value="{{$pengguna->photo}}">
                        </div>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Email Participant</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" value="{{$pengguna->email}}" name="email"
                                class="form-control phone-number">
                        </div>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" name="phone" value="{{$pengguna->phone}}"
                                class="form-control phone-number">
                        </div>
                        @if ($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <textarea name="alamat" class="form-control" id="" cols="30"
                                rows="10">{{$pengguna->alamat}}</textarea>
                        </div>
                        @if ($errors->has('alamat'))
                        <span class="text-danger">{{ $errors->first('alamat') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Photo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="file" accept="image/*" onchange="loadPhoto(event)" name="photo" id=""
                                class="form-control">
                        </div>
                        @if ($errors->has('photo'))
                        <span class="text-danger">{{ $errors->first('photo') }}</span>
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
                <img id="photo-image"
                    src="{{ env('BACKEND_ASSET_URL') . "assets/img/photo-pengguna/".$pengguna->photo}}"
                    style="width:100%" alt="">
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    var loadPhoto = function(event) {
        var outputPhoto = document.getElementById('photo-image');
        outputPhoto.src = URL.createObjectURL(event.target.files[0]);
        outputPhoto.onload = function() {
        URL.revokeObjectURL(outputPhoto.src) // free memory
        }
    };
</script>
@endpush