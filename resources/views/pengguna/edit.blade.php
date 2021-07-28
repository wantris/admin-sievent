@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('pengguna.update', $pengguna->id_pengguna)}}" enctype="multipart/form-data"
                    method="post">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label>Nama</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            @php
                            $nama = "Tidak Ada";
                            if ($pengguna->pembina_ref) {
                            $nama = $pengguna->pembina_ref->nama_dosen;
                            }elseif ($pengguna->wadir3_ref) {
                            $nama = $pengguna->wadir3_ref->nama_dosen;
                            }elseif ($pengguna->participant_ref) {
                            $nama = $pengguna->participant_ref->nama_participant;
                            }elseif ($pengguna->mahasiswa_ref) {
                            $nama = $pengguna->mahasiswa_ref;
                            }elseif ($pengguna->dosen_ref) {
                            $nama = $pengguna->dosen_ref;
                            }
                            @endphp
                            <input type="text" disabled value="{{$nama}}" name="username"
                                class="form-control phone-number">
                        </div>
                        @if ($errors->has('username'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>
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
                            <input type="text" name="password" class="form-control phone-number">
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
                            <input type="file" name="photo" id="" class="form-control">
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
                @if ($pengguna->photo)
                <img id="photo-image"
                    src="{{ env('BACKEND_ASSET_URL') . "assets/img/photo-pengguna/".$pengguna->photo}}"
                    style="width:100%" alt="">
                @else
                <img id="photo-image" src="{{asset('assets/icons/pengguna_icon2.png')}}" style="width:100%" alt="">
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>

</script>
@endpush