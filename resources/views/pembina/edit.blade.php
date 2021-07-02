@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('pembina.update', $id_pembina)}}" method="post">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label>Nama Dosen</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <select name="nidn" id="" class="form-control" required>
                                <option selected value="{{$pembina->nidn}}">{{$dosen->nama_dosen}}</option>
                                @foreach ($dosens as $dosen)
                                <option value="{{$dosen->nidn}}">{{$dosen->nama_dosen}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('nidn'))
                        <span class="text-danger">{{ $errors->first('nidn') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Ormawa</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <select name="ormawa" id="" class="form-control" required>
                                <option selected value="{{$pembina->ormawa_id}}">{{$pembina->ormawaRef->nama_ormawa}}
                                </option>
                                @foreach ($ormawas as $ormawa)
                                <option value="{{$ormawa->id_ormawa}}">{{$ormawa->nama_ormawa}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('ormawa'))
                        <span class="text-danger">{{ $errors->first('ormawa') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Tahun Jabatan</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-id-card"></i>
                                </div>
                            </div>
                            <input type="text" value="{{$pembina->periode}}" name="tahun" id="jabatan-inp"
                                class="form-control">
                        </div>
                        @if ($errors->has('status'))
                        <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-id-card"></i>
                                </div>
                            </div>
                            <select name="status" id="" class="form-control" required>
                                @if ($pembina->status == 1)
                                <option value="{{$pembina->status}}" selected>Aktif</option>
                                <option value="0">Tidak Aktif</option>
                                @else
                                <option value="{{$pembina->status}}" selected>Tidak Aktif</option>
                                <option value="1">Aktif</option>
                                @endif
                            </select>
                        </div>
                        @if ($errors->has('status'))
                        <span class="text-danger">{{ $errors->first('status') }}</span>
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
    $("#jabatan-inp").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    });
</script>
@endpush