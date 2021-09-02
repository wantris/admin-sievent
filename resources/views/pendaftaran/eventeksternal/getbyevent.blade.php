@extends('app')

@push('style')

@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-12 d-flex">
                        <a href="{{route('registrations.eventeksternal.exportExcel',$event->id_event_eksternal)}}" class="btn btn-success mr-2">Excel</a>
                        <a href="{{route('registrations.eventeksternal.exportPdf',$event->id_event_eksternal)}}" class="btn btn-success">PDF</a>
                    </div>
                </div>
                <table class="table table-bordered nowrap" id="table-pendaftaran" style="width: 100%">
                    <thead>
                        <tr>
                            <th>ID Pendaftaran</th>
                            <th>ID Tim</th>
                            <th>Nama Peserta/Ketua</th>
                            <th>Event</th>
                            <th>Sudah Tervalidasi</th>
                            <th>Status Pendaftar</th>
                            <th>Tahapan</th>
                            <th>Tahapan Terakhir</th>
                            <th>Tanggal</th>
                            <th class="table-plus datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registrations as $regis)
                            @if ($regis->event_eksternal_ref->role == "Individu")
                                <tr id="tr_{{$regis->id_event_eksternal_registration}}">
                                    <td width="5%">{{$regis->id_event_eksternal_registration}}</td>
                                    <td></td>
                                    <td>
                                        @if ($regis->nim)
                                            @if ($regis->mahasiswa_ref || $regis->mahasiswa_ref->count() > 0)
                                                {{$regis->mahasiswa_ref->mahasiswa_nama}}
                                            @else
                                                {{$regis->nim}}
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{$regis->event_eksternal_ref->nama_event}}</td>
                                    <td></td>
                                    <td>
                                        @if ($regis->status == "0")
                                            <a href="#" class="btn btn-warning" style="font-size: 12px">Belum</a> 
                                        @else
                                            <a href="#" class="btn btn-success" style="font-size: 12px">Sudah</a>
                                        @endif
                                    </td>
                                    <td>
                                        Mahasiswa Polindra
                                    </td>
                                    <td>
                                        @if ($regis->tahapan_regis_ref->count() > 0)
                                            @foreach ($regis->tahapan_regis_ref as $tahapan_regis)
                                            <i class="fas fa-fire text-danger font-weight-bold"></i>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if ($regis->tahapan_regis_ref->count() > 0)
                                            {{$regis->tahapan_regis_ref[0]->tahapan_event_eksternal->nama_tahapan}}
                                        @endif
                                    </td>
                                    <td>{{ date("d/m/Y", strtotime($regis->created_at)) }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu dropdown-action">
                                                @if ($regis->status == "1")
                                                    <a class="dropdown-item dropdown-action-item"  onclick="updateStatus({{$regis->id_event_eksternal_registration}}, '0')" href="#"><i class="fas fa-ban mr-2"></i>Buat Tidak Tervalidasi</a>
                                                @else
                                                    <a class="dropdown-item dropdown-action-item"  onclick="updateStatus({{$regis->id_event_eksternal_registration}}, '1')" href="#"><i class="fas fa-check-circle-2"></i>Buat Tervalidasi</a>
                                                @endif
                                                <a class="dropdown-item dropdown-action-item" href="{{route('tahapan.eventeksternal.pendaftaran.save',['eventid'=>$regis->event_eksternal_id,'regisid'=>$regis->id_event_eksternal_registration])}}"><i class="fas fa-fire mr-2"></i>Ke Tahap Selanjutnya</a>
                                                <a class="dropdown-item dropdown-action-item" onclick="deleteTim({{$regis->id_event_eksternal_registration}})" href="#"><i class="fas fa-trash-alt mr-2"></i>Hapus</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                <tr id="tr_{{$regis->id_event_eksternal_registration}}">
                                    <td width="5%">{{$regis->id_event_eksternal_registration}}</td>
                                    <td>{{$regis->tim_event_id}}</td>
                                    <td>
                                        @foreach ($regis->tim_ref->tim_detail_ref as $detail)
                                            @if ($detail->role == "ketua")
                                                @if ($detail->nim)
                                                    @if ($detail->mahasiswa_ref|| $regis->mahasiswa_ref->count() > 0)
                                                        {{$detail->mahasiswa_ref->mahasiswa_nama}}
                                                    @else
                                                        {{$detail->nim}}
                                                    @endif
                                                @endif
                                            @endif
                                        @endforeach    
                                    </td>
                                    <td>{{$regis->event_eksternal_ref->nama_event}}</td>
                                    <td>
                                        @if ($regis->status == "0")
                                            <a href="#" class="btn btn-warning" style="font-size: 12px">Belum</a>
                                        @else
                                            <a href="#" class="btn btn-success" style="font-size: 12px">Sudah</a> 
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($regis->tim_ref->tim_detail_ref as $detail)
                                            @if ($detail->role == "ketua")
                                                @if ($detail->nim)
                                                    Mahasiswa Polindra
                                                @endif
                                            @endif
                                        @endforeach  
                                    </td>
                                    <td>
                                        @foreach ($regis->tahapan_regis_ref as $tahapan_regis)
                                            <i class="fas fa-fire text-danger font-weight-bold"></i>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{$regis->tahapan_regis_ref[0]->tahapan_event_eksternal->nama_tahapan}}
                                    </td>
                                    <td>{{ date("d/m/Y", strtotime($regis->created_at)) }}</td>
                                    <td>
                                        @php
                                            $tim_detail_json = json_encode($regis->tim_ref->tim_detail_ref);
                                        @endphp
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu dropdown-action">
                                                <a class="dropdown-item dropdown-action-item" onclick="detailTim({{$tim_detail_json}})" href="#"><i class="fas fa-eye mr-2"></i>Detail Tim</a>
                                                @if ($regis->status == "1")
                                                    <a class="dropdown-item dropdown-action-item"  onclick="updateStatus({{$regis->id_event_eksternal_registration}}, '0')" href="#"><i class="fas fa-ban mr-2"></i>Buat Tidak Tervalidasi</a>
                                                @else
                                                    <a class="dropdown-item dropdown-action-item"  onclick="updateStatus({{$regis->id_event_eksternal_registration}}, '1')" href="#"><i class="fas fa-check-circle-2"></i>Buat Tervalidasi</a>
                                                @endif
                                                <a class="dropdown-item dropdown-action-item" href="{{route('tahapan.eventeksternal.pendaftaran.save',['eventid'=>$regis->event_eksternal_id,'regisid'=>$regis->id_event_eksternal_registration])}}"><i class="fas fa-fire mr-2"></i>Ke Tahap Selanjutnya</a>
                                                <a class="dropdown-item dropdown-action-item" onclick="deleteTim({{$regis->id_event_eksternal_registration}})" href="#"><i class="fas fa-trash-alt mr-2"></i>Hapus</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="timDetailModal" tabindex="1500" role="dialog" aria-labelledby="timDetailModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Detail Tim</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-body-detail">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <p class="">Nama</p>
                </div>
                <div class="col-lg-1">:</div>
                <div class="col-lg-6 col-12">
                    <p class="">Status</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-12">
                    <p class="">Role</p>
                </div>
                <div class="col-lg-1">:</div>
                <div class="col-lg-6 col-12">
                    <p class="">Anggota</p>
                </div>
            </div>
            <hr>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')


<script>

    $(document).ready(function () {
        var $dTable = $('#table-pendaftaran').DataTable({
            responsive: true
        });

        new $.fn.dataTable.FixedHeader( $dTable );

    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const detailTim = (values) =>{
        event.preventDefault();
        $('#timDetailModal').appendTo("body").modal('show');

        let html = ``;
        $.each(values, function (i, item) {
            if(item.status = "Done"){
                if(item.nim){
                html += `
                    <div class="row">
                        <div class="col-lg-3 col-12">
                            <p class="">Nama</p>
                        </div>
                        <div class="col-lg-1">:</div>
                        <div class="col-lg-6 col-12">
                            <p class="text-primary font-weight-bold">${item.mahasiswa_ref.mahasiswa_nama}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-12">
                            <p class="">Status</p>
                        </div>
                        <div class="col-lg-1">:</div>
                        <div class="col-lg-6 col-12">
                            <p class="text-primary font-weight-bold">Mahasiswa Polindra</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-12">
                            <p class="">Program Studi</p>
                        </div>
                        <div class="col-lg-1">:</div>
                        <div class="col-lg-6 col-12">
                            <p class="text-primary font-weight-bold">${item.mahasiswa_ref.program_studi_kode}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-12">
                            <p class="">Role</p>
                        </div>
                        <div class="col-lg-1">:</div>
                        <div class="col-lg-6 col-12">
                            <p class="text-primary font-weight-bold">${item.role}</p>
                        </div>
                    </div>
                    <hr>
                `;
            }else{
                html += `
                    <div class="row">
                        <div class="col-lg-3 col-12">
                            <p class="">Nama</p>
                        </div>
                        <div class="col-lg-1">:</div>
                        <div class="col-lg-6 col-12">
                            <p class="text-primary font-weight-bold">${item.participant_ref.nama_participant}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-12">
                            <p class="">Status</p>
                        </div>
                        <div class="col-lg-1">:</div>
                        <div class="col-lg-6 col-12">
                            <p class="text-primary font-weight-bold">Partisipan Eksternal</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-12">
                            <p class="">Role</p>
                        </div>
                        <div class="col-lg-1">:</div>
                        <div class="col-lg-6 col-12">
                            <p class="text-primary font-weight-bold">${item.role}</p>
                        </div>
                    </div>
                    <hr>
                `;
            }
            }
        });

        $('#modal-body-detail').html(html);
    }

    const deleteTim = (id_tim) => {
        let url = "/team/delete/"+id_tim;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Pendaftaran Event',
            'Apakah anda yakin ingin menghapus?',
            'Yes',
            'No',
             function(){ 
                $.ajax(
                    {
                        url: url,
                        type: 'delete', 
                        dataType: "JSON",
                        data: {
                            "id_tim": id_tim 
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                $('#tr_' + id_tim).remove();
                            }
                        },
                        error: function(xhr) {
                            Notiflix.Notify.Failure('Ooopss');
                        }
                });
            }, function(){
                 // No button callback alert('If you say so...'); 
            } ); 
    }

    const updateStatus = (id_regis, status) => {
        let url = "/registration/eventeksternal/updatestatus/"+id_regis;
        event.preventDefault();

        console.log(typeof status);

        if(status == "1"){
            $msg = "Buat Tervalidasi";
        }else{
            $msg = "Buat Tidak Tervalidasi";
        }

        Notiflix.Confirm.Show( 
            $msg,
            'Apakah anda yakin?',
            'Yes',
            'No',
             function(){ 
                $.ajax(
                    {
                        url: url,
                        type: 'POST', 
                        dataType: "JSON",
                        data: {
                            "status": status 
                        },
                        success: function (response){
                            console.log(response);
                            if(response.status == 1){
                                location.reload();
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr);
                            Notiflix.Notify.Failure('Ooopss');
                        }
                });
            }, function(){
                 // No button callback alert('If you say so...'); 
            } ); 
    }
</script>
@endpush