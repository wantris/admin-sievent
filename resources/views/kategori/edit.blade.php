@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('kategorievent.update', $id_kategori)}}" method="post">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label>Nama Kategori Event</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </div>
                            </div>
                            <input type="text" value="{{$kategori->nama_kategori}}" required name="nama"
                                class="form-control phone-number">
                        </div>
                        @if ($errors->has('nama'))
                        <span class="text-danger">{{ $errors->first('nama') }}</span>
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