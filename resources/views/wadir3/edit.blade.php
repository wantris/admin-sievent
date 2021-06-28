@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('wadir3.update', $id)}}" method="post">
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
                            <select id="" class="form-control" required disabled>
                                <option selected value="{{(int)$wadir3->nidn}}">{{$dosen->nama_dosen}}</option>
                            </select>   
                            <input type="hidden" name="nidn" value="{{(int)$wadir3->nidn}}">                        
                        </div>
                        @if ($errors->has('nidn'))
                            <span class="text-danger">{{ $errors->first('nidn') }}</span>
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
                                @if ($wadir3->status == 1)
                                    <option value="{{$wadir3->status}}" selected>Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                @else
                                    <option value="{{$wadir3->status}}" selected>Tidak Aktif</option>
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

</script>
@endpush

