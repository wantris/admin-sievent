@extends('app')

@push('style')
<style>
    .btn-danger {
        background-color: #fb160a !important;
    }

    .btn-danger__active {
        background-color: #fc544b !important;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="{{route('pengguna.relasi.update', $pengguna->id_pengguna)}}" method="post">
                @csrf
                @method('patch')
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4">
                            <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#pembina"
                                        role="tab" aria-controls="home" aria-selected="true">Pembina</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#wadir3" role="tab"
                                        aria-controls="profile" aria-selected="false">Wadir3</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#mahasiswa" role="tab"
                                        aria-controls="contact" aria-selected="false">Mahasiswa</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8">
                            <div class="tab-content no-padding" id="myTab2Content">
                                <div class="tab-pane fade show active" id="pembina" role="tabpanel"
                                    aria-labelledby="home-tab4">
                                    <div class="form-group">
                                        <select id="pembina-inp" class="js-example-basic-single" name="pembina">
                                            @if ($pengguna->pembinaRef)
                                            <option data-selected="true" selected value="{{$pengguna->pembina_id}}">
                                                {{$pengguna->pembinaRef->nama_dosen}}</option>
                                            @else
                                            <option data-selected="false" value="undefined" selected>Pilih Pembina
                                            </option>
                                            @endif
                                            @foreach ($pembinas as $pembina)
                                            <option data-selected="false" value="{{$pembina->id_pembina}}">
                                                {{$pembina->nama_dosen}}</option>
                                            @endforeach
                                        </select>
                                        <label class="custom-switch">
                                            <input type="checkbox" id="disable-pembina" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Disable pilihan</span>
                                        </label>
                                        @if ($errors->has('pembina'))
                                        <span class="text-danger">{{ $errors->first('pembina') }}</span>
                                        @endif
                                    </div>
                                    <input type="submit" value="Submit" class="btn btn-primary" style="width: 100%">
                                </div>
                                <div class="tab-pane fade" id="wadir3" role="tabpanel" aria-labelledby="profile-tab4">
                                    <div class="form-group">
                                        <select id="wadir3-inp" class="js-example-basic-single" name="wadir3">
                                            @if ($pengguna->wadir3Ref)
                                            <option data-selected="true" selected value="{{$pengguna->wadir3_id}}">
                                                {{$pengguna->wadir3Ref->nama_dosen}}</option>
                                            @else
                                            <option value="undefined" selected>Pilih Wadir3</option>
                                            @endif
                                            @foreach ($wadir3s as $wadir3)
                                            <option data-selected="false" value="{{$wadir3->id_wadir3}}">
                                                {{$wadir3->nama_dosen}}</option>
                                            @endforeach
                                        </select>
                                        <label class="custom-switch">
                                            <input type="checkbox" id="disable-wadir3" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Disable pilihan</span>
                                        </label>
                                        @if ($errors->has('wadir3'))
                                        <span class="text-danger">{{ $errors->first('wadir3') }}</span>
                                        @endif
                                    </div>
                                    <input type="submit" value="Submit" class="btn btn-primary" style="width: 100%">
                                </div>
                                <div class="tab-pane fade" id="mahasiswa" role="tabpanel"
                                    aria-labelledby="contact-tab4">
                                    <div class="form-group">
                                        <select id="mhs-inp" class="js-example-basic-single" name="mhs">
                                            @if ($pengguna->nama_mahasiswa)
                                            <option data-selected="true" value="{{$pengguna->nim}}">
                                                {{$pengguna->nama_mahasiswa}}</option>
                                            @else
                                            <option value="undefined" selected>Pilih Mahasiswa</option>
                                            @endif
                                            @foreach ($mahasiswas as $mahasiswa)
                                            <option data-selected="false" value="{{$mahasiswa->nim}}">
                                                {{$mahasiswa->nama}}</option>
                                            @endforeach
                                        </select>
                                        <label class="custom-switch">
                                            <input type="checkbox" id="disable-mhs" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Disable pilihan</span>
                                        </label>
                                        @if ($errors->has('mhs'))
                                        <span class="text-danger">{{ $errors->first('mhs') }}</span>
                                        @endif
                                    </div>
                                    <input type="submit" value="Submit" class="btn btn-primary" style="width: 100%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.js-example-basic-single').select2();

        const disableAnother = () => {
            $('#disable-wadir3').prop("checked", true);
            $('#disable-pembina').prop("checked", true);
            $('#wadir3-inp').attr("disabled", true);
            $('#pembina-inp').attr("disabled", true);
       }

       const undisableAnother = () => {
            $('#disable-wadir3').prop("checked", false);
            $('#disable-pembina').prop("checked", false);
            $('#wadir3-inp').attr("disabled", false);
            $('#pembina-inp').attr("disabled", false);
       }

        $('#disable-mhs').on('change',function() {
            if ($(this).is(':checked')) {
                $('#mhs-inp').attr("disabled", true);
                undisableAnother();
            }else{
                $('#mhs-inp').removeAttr("disabled", true);
                disableAnother();
            }
        });
        
        $('#disable-pembina').change(function() {
            if ($(this).is(':checked')) {
                $('#pembina-inp').attr("disabled", true);
            }else{
                $('#pembina-inp').removeAttr("disabled", true);
            }
        });

        $('#disable-wadir3').change(function() {
            if ($('#disable-wadir3').is(':checked')) {
                $('#wadir3-inp').attr("disabled", true);
            }else{
                $('#wadir3-inp').removeAttr("disabled", true);
            }
        });

        if($('#pembina-inp').find(':selected').val() != "undefined"){
            $('#disable-mhs').prop("checked", true);
            $('#mhs-inp').attr("disabled", true);
        }

        if($('#wadir3-inp').find(':selected').val() != "undefined"){
            $('#disable-mhs').prop("checked", true);
            $('#mhs-inp').attr("disabled", true);
        }

        if($('#mhs-inp').find(':selected').val() != "undefined"){
           disableAnother();
        }
    
    });
    

</script>
@endpush