@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('ormawa.save')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Nama Ormawa</label>
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
                        <label>Nama Akronim</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" name="akronim" class="form-control phone-number">
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
                            <input type="text" required name="username" class="form-control phone-number">
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
                                    <i class="fas fa-key"></i>
                                </div>
                            </div>
                            <input type="text" required name="password" class="form-control phone-number">
                        </div>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
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