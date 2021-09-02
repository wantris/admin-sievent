@extends('app')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-3">                
                    <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle img-fluid">
                </div>
                <div class="col-12 col-md-12 col-lg-9">
                    <div class="card">
                        <form method="post" class="needs-validation" action="{{route('account.save')}}">
                            @csrf
                            <div class="card-header">
                                <h4>Edit Profile</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">                               
                                    <div class="form-group col-md-6 col-12">
                                        <label>Nama</label>
                                        @if ($pengguna->dosenRef)
                                            <input type="text" class="form-control" disabled value="{{$pengguna->dosenRef->dosen_lengkap_nama}}">
                                        @else
                                            <input type="text" class="form-control" disabled value="{{$pengguna->nidn}}">
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Username</label>
                                        <input type="text" class="form-control" disabled value="{{$pengguna->username}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-7 col-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" value="{{$pengguna->email}}">
                                        <small class="text-muted">Wajib Diisi</small>
                                        <div class="invalid-feedback">
                                            Please fill in the email
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5 col-12">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="phone" value="{{$pengguna->email}}">
                                        <small class="text-muted">Wajib Diisi</small>
                                        <div class="invalid-feedback">
                                            Please fill in the phone
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                    <label>Alamat</label>
                                    <textarea class="form-control summernote-simple" name="alamat">{{$pengguna->alamat}}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                    <label>Photo</label>
                                    <input type="file" name="photo" class="form-control" id="">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')

@endpush