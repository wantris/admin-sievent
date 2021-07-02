@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('cakupanOrmawa.update', $cakupan->id_cakupan_ormawa)}}" method="post">
                    @method('patch')
                    @csrf
                    <div class="form-group">
                        <label>Nama ormawa</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <select class="form-control" name="ormawa" id="ormawa-inp">
                                @if ($cakupan->ormawa_id)
                                <option selected value="{{$cakupan->ormawa_id}}">{{$cakupan->ormawaRef->nama_ormawa}}
                                </option>
                                @else
                                <option selected>Pilih Nama Ormawa</option>
                                @endif
                                @foreach ($ormawas as $ormawa)
                                <option data-nama="{{$ormawa->nama_ormawa}}" value="{{$ormawa->id_ormawa}}">
                                    {{$ormawa->nama_ormawa}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('ormawa'))
                        <span class="text-danger">{{ $errors->first('ormawa') }}</span>
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
                            <input type="text" value="{{$cakupan->role}}" name="role" class="form-control"
                                id="role-input">
                        </div>
                        @if ($errors->has('role'))
                        <span class="text-danger">{{ $errors->first('role') }}</span>
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
    $('#ormawa-inp').on('change', function(){
        var selected = $(this).find('option:selected');
        var nama = selected.data('nama'); 

        if(typeof nama != 'undefined'){
            $('#role-input').val(nama)
        }else{
            $('#role-input').val('')
        }
    })
</script>
@endpush