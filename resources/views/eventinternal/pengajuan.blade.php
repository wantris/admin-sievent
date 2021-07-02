@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body">
                <ul class="nav nav-pills" id="myTab3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#pengajuan" role="tab"
                            aria-controls="home" aria-selected="true">Pengajuan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#event-internal" role="tab"
                            aria-controls="profile" aria-selected="false">Event Internal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#berkas" role="tab"
                            aria-controls="profile" aria-selected="false">Berkas Pengajuan</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="pengajuan" role="tabpanel" aria-labelledby="home-tab">
                        <form action="{{route('eventinternal.pengajuan.update', $pengajuan->id_event_internal_detail)}}"
                            method="post">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <label>Nama Event</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-signature"></i>
                                        </div>
                                    </div>
                                    <input type="text" disabled value="{{$pengajuan->event_internal_ref->nama_event}}"
                                        name="nama" class="form-control phone-number">
                                    <input type="hidden" required value="{{$pengajuan->event_internal_id}}"
                                        name="event_internal_id" class="form-control phone-number">
                                </div>
                                @if ($errors->has('event_internal_id'))
                                <span class="text-danger">{{ $errors->first('event_internal_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Sudah divalidasi pembina</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-signature"></i>
                                        </div>
                                    </div>
                                    <select name="validate_pembina" id="" class="form-control">
                                        @if ($pengajuan->is_validated_pembina == 1)
                                        <option selected value="{{$pengajuan->is_validated_pembina}}">Sudah</option>
                                        <option value="0">Belum</option>
                                        @else
                                        <option selected value="{{$pengajuan->is_validated_pembina}}">Belum</option>
                                        <option value="1">Sudah</option>
                                        @endif
                                    </select>
                                </div>
                                @if ($errors->has('validate_pembina'))
                                <span class="text-danger">{{ $errors->first('validate_pembina') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Sudah divalidasi wadir 3</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-signature"></i>
                                        </div>
                                    </div>
                                    <select name="validate_wadir3" id="" class="form-control">
                                        @if ($pengajuan->is_validated_pembina == 1)
                                        <option selected value="{{$pengajuan->is_validated_wadir3}}">Sudah</option>
                                        <option value="0">Belum</option>
                                        @else
                                        <option selected value="{{$pengajuan->is_validated_wadir3}}">Belum</option>
                                        <option value="1">Sudah</option>
                                        @endif
                                    </select>
                                </div>
                                @if ($errors->has('validate_wadir3'))
                                <span class="text-danger">{{ $errors->first('validate_wadir3') }}</span>
                                @endif
                            </div>
                            <input type="submit" value="Submit" class="btn btn-primary" style="width: 100%">
                        </form>
                    </div>
                    <div class="tab-pane fade event-internal" id="event-internal" role="tabpanel"
                        aria-labelledby="profile-tab">
                        <img id="photo-image"
                            src="{{ env('BACKEND_ASSET_URL') . "assets/img/kompetisi-thumb/".$pengajuan->event_internal_ref->poster_image}}"
                            style="width:100%" alt="">
                        <form action="" enctype="multipart/form-data" method="post">
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
                                    <select disabled class="form-control" name="ormawa" id="">
                                        <option value="{{$pengajuan->event_internal_ref->ormawa_id}}" selected>
                                            {{$pengajuan->ormawa_ref->nama_ormawa}}
                                        </option>
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
                                    <input disabled type="text" required
                                        value="{{$pengajuan->event_internal_ref->nama_event}}" name="nama"
                                        class="form-control phone-number">
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
                                    <select disabled class="form-control" name="kategori" id="">
                                        <option value="{{$pengajuan->ormawa_ref->kategori_ref->id_kategori}}" selected>
                                            {{$pengajuan->ormawa_ref->kategori_ref->nama_kategori}}
                                        </option>
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
                                    <select disabled class="form-control" name="tipe_peserta" id="">
                                        <option value="{{$pengajuan->ormawa_ref->tipe_ref->id_tipe_peserta}}" selected>
                                            {{$pengajuan->ormawa_ref->tipe_ref->nama_tipe}}
                                        </option>
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
                                    <input disabled type="text" required
                                        value="{{$pengajuan->event_internal_ref->maks_participant}}" name="maks"
                                        class="form-control phone-number">
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
                                    <input disabled type="text" required
                                        value="{{$pengajuan->event_internal_ref->role}}" name="role"
                                        class="form-control phone-number">
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
                                    <input disabled type="date" required
                                        value="{{$pengajuan->event_internal_ref->tgl_buka}}" name="tgl_buka"
                                        class="form-control phone-number">
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
                                    <input disabled type="date" required
                                        value="{{$pengajuan->event_internal_ref->tgl_tutup}}" name="tgl_tutup"
                                        class="form-control phone-number">
                                </div>
                                @if ($errors->has('tgl_tutup'))
                                <span class="text-danger">{{ $errors->first('tgl_tutup') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea disabled name="deskripsi"
                                    class="form-control">{{$pengajuan->event_internal_ref->deskripsi}}</textarea>

                                @if ($errors->has('deksripsi'))
                                <span class="text-danger">{{ $errors->first('deksripsi') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Ketentuan</label>
                                <textarea disabled name="ketentuan"
                                    class="form-control">{{$pengajuan->event_internal_ref->ketentuan}}</textarea>

                                @if ($errors->has('ketentuan'))
                                <span class="text-danger">{{ $errors->first('ketentuan') }}</span>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade berkas" id="berkas" role="tabpanel" aria-labelledby="profile-tab">
                        @foreach ($pengajuan->file_pengajuan as $item)
                        <div class="row mb-3">
                            <div class="col-1"><a data-toggle="collapse"
                                    href="#collapseExample_{{$item->id_berkas_event_detail}}" role="button"
                                    aria-expanded="false" aria-controls="collapseExample"><img
                                        src="{{url('assets/icons/pdf.svg')}}" alt=""></a></div>
                            <div class="col-3">
                                <input type="text"
                                    style="border:none; background:none; border-bottom:1px solid #6777ef !important"
                                    name="" disabled value="Berkas Pengajuan Event" id="">
                            </div>
                        </div>
                        <div class="collapse" id="collapseExample_{{$item->id_berkas_event_detail}}">
                            <div class="container_berkas" data-filename="{{$item->filename}}"
                                data-id="{{$item->id_berkas_event_detail}}"
                                id="pengajuan_{{$item->id_berkas_event_detail}}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.5/pdfobject.js"
    integrity="sha512-eCQjXTTg9blbos6LwHpAHSEZode2HEduXmentxjV8+9pv3q1UwDU1bNu0qc2WpZZhltRMT9zgGl7EzuqnQY5yQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    CKEDITOR.replace('deskripsi',{
      language:'en-gb'
    });
    CKEDITOR.replace('ketentuan',{
      language:'en-gb'
    });
    CKEDITOR.config.allowedContent = true;

    $('.container_berkas').each(function(){
        let id = $(this).data('id');
        let url = "{{env('BACKEND_ASSET_URL') . 'assets/berkas-pengajuan/'}}/" + $(this).data('filename');
        let container = "#pengajuan_"+id;
        PDFObject.embed(url, container);
    });


</script>
@endpush