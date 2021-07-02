@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('participant.update', $ps->id_participant)}}" enctype="multipart/form-data"
                    method="post">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label>Nama Participant</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" value="{{$ps->nama_participant}}" required name="nama"
                                class="form-control phone-number">
                        </div>
                        @if ($errors->has('nama'))
                        <span class="text-danger">{{ $errors->first('nama') }}</span>
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
                            <input type="text" required value="{{$ps->pengguna_ref->username}}" name="username"
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
                            <input type="hidden" name="oldPassword" value="{{$ps->pengguna_ref->password}}">
                            <input type="hidden" name="oldPhoto" value="{{$ps->pengguna_ref->photo}}">
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
                            <input type="text" value="{{$ps->pengguna_ref->email}}" required name="email"
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
                            <input type="text" required name="phone" value="{{$ps->pengguna_ref->phone}}"
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
                                rows="10">{{$ps->pengguna_ref->alamat}}</textarea>
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
                <img id="photo-image"
                    src="{{ env('BACKEND_ASSET_URL') . "assets/img/photo-pengguna/".$ps->pengguna_ref->photo}}"
                    style="width:100%" alt="">
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>

</script>
@endpush