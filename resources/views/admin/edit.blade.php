@extends('app')

@section('content')
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <form action="{{route('admin.update',$id)}}" method="post">
          @method('patch')
          @csrf
          <div class="form-group">
            <label>Nama</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-signature"></i>
                </div>
              </div>
              <input type="text" name="nama" value="{{$admin->nama}}" class="form-control phone-number">
            </div>
          </div>
          <div class="form-group">
            <label>Username</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-id-card"></i>
                </div>
              </div>
              <input type="text" name="username" value="{{$admin->username}}" class="form-control phone-number"
                required>
              <div class="invalid-feedback">
                Username wajib diisi
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Password</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-key"></i>
                </div>
              </div>
              <input type="text" name="oldPassword" class="form-control phone-number" value="{{$admin->password}}"
                hidden>
              <input type="text" name="newPassword" class="form-control phone-number">
              <div class="invalid-feedback">
                Password wajib diisi
              </div>
            </div>
          </div>

          <input type="submit" value="Submit" class="btn btn-primary" style="width: 100%">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script>

</script>
@endpush