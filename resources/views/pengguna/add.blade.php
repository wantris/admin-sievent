@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('pengguna.save')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Username*</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" required name="username" class="form-control phone-number">
                        </div>
                        <small class="form-text text-muted">Wajib Diisi</small>
                        @if ($errors->has('username'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Password*</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" required name="password" class="form-control phone-number">
                        </div>
                        <small class="form-text text-muted">Wajib Diisi</small>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Pembina</label>
                        <select id="pembina-inp" class="js-example-basic-single" name="pembina">
                            <option value="undefined" selected>Pilih Pembina</option>
                            @foreach ($pembinas as $pembina)
                            <option value="{{$pembina->id_pembina}}">{{$pembina->nama_dosen}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('pembina'))
                        <span class="text-danger">{{ $errors->first('pembina') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Wadir3</label>
                        <select id="wadir3-inp" class="js-example-basic-single" name="wadir3">
                            <option value="undefined" selected>Pilih Wadir3</option>
                            @foreach ($wadir3s as $wadir3)
                            <option value="{{$wadir3->id_wadir3}}">{{$wadir3->nama_dosen}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('wadir3'))
                        <span class="text-danger">{{ $errors->first('wadir3') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Mahasiswa</label>
                        <select id="mhs-inp" class="js-example-basic-single" name="mhs">
                            <option value="undefined" selected>Pilih Mahasiswa</option>
                            @foreach ($mahasiswas as $mahasiswa)
                            <option value="{{$mahasiswa->nim}}">{{$mahasiswa->nama}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('mhs'))
                        <span class="text-danger">{{ $errors->first('mhs') }}</span>
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
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
    

    // PEMBINA INP
    $('#pembina-inp').on('change', function(){
        let value = $(this).val();
        if(value != "undefined"){
            $("#mhs-inp").attr("disabled", true);
            $("#wadir3-inp").attr("disabled", true);
        }else{
            $("#mhs-inp").removeAttr("disabled", true);
            $("#wadir3-inp").removeAttr("disabled", true);
        }
    });

    // WADIR INP
    $('#wadir3-inp').on('change', function(){
        let value = $(this).val();
        if(value != "undefined"){
            $("#mhs-inp").attr("disabled", true);
            $("#pembina-inp").attr("disabled", true);
        }else{
            $("#mhs-inp").removeAttr("disabled", true);
            $("#pembina-inp").removeAttr("disabled", true);
        }
    });

    // MHS INP
    $('#mhs-inp').on('change', function(){
        let value = $(this).val();
        console.log(value);
        if(value != "undefined"){
            $("#pembina-inp").attr("disabled", true);
            $("#wadir3-inp").attr("disabled", true);
        }else{
            $("#pembina-inp").removeAttr("disabled", true);
            $("#wadir3-inp").removeAttr("disabled", true);
        }
    });
</script>
@endpush