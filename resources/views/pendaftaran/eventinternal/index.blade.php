@extends('app')

@push('style')

@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-lg-3 col-12">
                        <select name="event" id="event-select" class="form-control">
                            <option value="">Semua Event</option>
                            @foreach ($events as $event)
                                <option value="{{$event}}">{{$event}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-12">
                        <select name="event" id="event-select" class="form-control">
                            <option value="">Semua Ormawa</option>
                            @foreach ($ormawas as $ormawa)
                                <option value="{{$ormawa}}">{{$ormawa}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <table class="table table-bordered nowrap" id="table-pendaftaran" style="width: 100%">
                    <thead>
                        <tr>
                            <th>ID Pendaftaran</th>
                            <th>ID Tim</th>
                            <th >Nama Peserta/Ketua</th>
                            <th>Event</th>
                            <th>Sudah Tervalidasi</th>
                            <th>Status Pendaftar</th>
                            <th>Tanggal</th>
                            <th class="table-plus datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registrations as $regis)
                            @if ($regis->event_internal_ref->role == "Individu")
                                <tr id="tr_{{$regis->id_event_internal_registration}}">
                                    <td width="5%">{{$regis->id_event_internal_registration}}</td>
                                    <td></td>
                                    <td>
                                        @if ($regis->nim)
                                            @if ($regis->mahasiswa_ref)
                                                {{$regis->mahasiswa_ref->mahasiswa_nama}}
                                            @else
                                                {{$regis->nim}}
                                            @endif
                                        @else
                                            {{$regis->participant_ref->nama_participant}}
                                        @endif
                                    </td>
                                    <td>{{$regis->event_internal_ref->nama_event}}</td>
                                    <td></td>
                                    <td>
                                        @if ($regis->status == "0")
                                            <a href="#" class="btn btn-warning" style="font-size: 12px">Belum</a> 
                                        @else
                                            <a href="#" class="btn btn-success" style="font-size: 12px">Sudah</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($regis->nim)
                                            Mahasiswa Polindra
                                        @else
                                            Partisipan Eksternal
                                        @endif
                                    </td>
                                    <td>{{ date("d/m/Y", strtotime($regis->created_at)) }}</td>
                                    <td>
                                        @if ($regis->status == "1")
                                            <a href="#" onclick="updateStatus({{$regis->id_event_internal_registration}}, '0')" class="btn btn-secondary d-inline-block mb-1" title="Buat Tidak Tervalidasi"><i class="fas fa-ban"></i></a>
                                        @else
                                            <a href="#" onclick="updateStatus({{$regis->id_event_internal_registration}}, '1')" class="btn btn-primary d-inline-block mb-1" title="Buat Tervalidasi"><i class="fas fa-check-circle"></i></a>
                                        @endif
                                        <a href="#" onclick="deleteTim({{$regis->id_event_internal_registration}})"
                                            class="btn btn-danger d-inline-block mb-1" title="Hapus"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @else
                                <tr id="tr_{{$regis->id_event_internal_registration}}">
                                    <td width="5%">{{$regis->id_event_internal_registration}}</td>
                                    <td>{{$regis->tim_event_id}}</td>
                                    <td>
                                        @foreach ($regis->tim_ref->tim_detail_ref as $detail)
                                            @if ($detail->role == "ketua")
                                                @if ($detail->nim)
                                                    @if ($detail->mahasiswa_ref)
                                                        {{$detail->mahasiswa_ref->mahasiswa_nama}}
                                                    @else
                                                        {{$detail->nim}}
                                                    @endif
                                                @else
                                                    {{$detail->participant_ref->nama_participant}}
                                                @endif
                                            @endif
                                        @endforeach    
                                    </td>
                                    <td>{{$regis->event_internal_ref->nama_event}}</td>
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
                                                @else
                                                    Partisipan Eksternal
                                                @endif
                                            @endif
                                        @endforeach  
                                    </td>
                                    <td>{{ date("d/m/Y", strtotime($regis->created_at)) }}</td>
                                    <td>
                                        @php
                                            $tim_detail_json = json_encode($regis->tim_ref->tim_detail_ref);
                                        @endphp
                                        <a href="#" onclick="detailTim({{$tim_detail_json}})" class="btn btn-success d-inline-block mb-1" title="Detail"><i class="fas fa-eye"></i></a>
                                        @if ($regis->status == "1")
                                            <a href="#" onclick="updateStatus({{$regis->id_event_internal_registration}}, '0')" class="btn btn-secondary d-inline-block mb-1" title="Buat Tidak Tervalidasi"><i class="fas fa-ban"></i></a>
                                        @else
                                            <a href="#" onclick="updateStatus({{$regis->id_event_internal_registration}}, '1')" class="btn btn-primary d-inline-block mb-1" title="Buat Tervalidasi"><i class="fas fa-check-circle"></i></a>
                                        @endif
                                        <a href="#" onclick="deleteTim({{$regis->id_event_internal_registration}})"
                                            class="btn btn-danger d-inline-block mb-1" title="Hapus"><i class="fas fa-trash-alt"></i></a>
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
    var start_date;
    var end_date;
    var bulan = ['', 'Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    var start_month;
    var end_month;

    var DateFilterFunction = (function (oSettings, aData, iDataIndex) {
        var dateStart = parseDateValue(start_date);
        var dateEnd = parseDateValue(end_date);
        var evalDate= parseDateValue(aData[5]);
       
        if ( ( isNaN( dateStart ) && isNaN( dateEnd ) ) ||
            ( isNaN( dateStart ) && evalDate <= dateEnd ) ||
            ( dateStart <= evalDate && isNaN( dateEnd ) ) ||
            ( dateStart <= evalDate && evalDate <= dateEnd ) )
        {
            return true;
        }
        return false;
    });

    function parseDateValue(rawDate) {
        var dateArray= rawDate.split("/");
        var parsedDate= new Date(dateArray[2], parseInt(dateArray[1])-1, dateArray[0]);  // -1 because months are from 0 to 11   
        return parsedDate;
    }   

    function convertStart(start_date){
        start_date = start_date.split("/").reverse().join("-");
        var parts_start = start_date.split("-");
        start_month = parts_start[2] + " " + bulan[parseInt(parts_start[1])] + " "+ parts_start[0];
        console.log(start_month, parseInt(parts_start[1]));
    }


    function convertEnd(end_date){
        end_date = end_date.split("/").reverse().join("-");
        var parts_end = end_date.split("-");
        end_month = parts_end[2] + " " + bulan[parseInt(parts_end[1])] + " "+ parts_end[0];
    }

    $(document).ready(function () {
        var $dTable = $('#table-pendaftaran').DataTable({
            responsive: true,
            "dom":"<'row'<'col-sm-3'l>B<'col-sm-3' <'datesearchbox'>><'col-sm-3'f>>",
                buttons: [   
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        },
                        customize: function ( xlsx ) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            if(start_date != null && end_date != null){
                                convertStart(String(start_date));
                                convertEnd(String(end_date));
                                $('c[r=A1] t', sheet).text( 'Data Pendaftar '+ start_month + " - "+ end_month);
                                $('row:first c', sheet).attr( 's', '51', '2' ); // first row is bold
                            }else{
                                $('c[r=A1] t', sheet).text( 'Data Pendaftar');
                                $('row:first c', sheet).attr( 's', '51', '2' ); // first row is bold
                            }
                        }
                    }
                ],
        });

        new $.fn.dataTable.FixedHeader( $dTable );

        let status = '';
        let kategori = '';

        $('#event-select').on('change', function(){
            $dTable.column(2).search(this.value).draw();  
        });

        //menambahkan daterangepicker di dalam datatables
        $("div.datesearchbox").html('<div class="input-group mb-3"> <div class="input-group-addon"> <i class="glyphicon glyphicon-calendar"></i> </div><input type="text" class="form-control pull-right" id="datesearch" placeholder="Berdasarkan Tanggal.."> </div>');

        document.getElementsByClassName("datesearchbox")[0].style.textAlign = "right";

        $('#datesearch').daterangepicker({
            autoUpdateInput: false,
            useCurrent: false

        });

        $('#datesearch').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            start_date=picker.startDate.format('DD/MM/YYYY');
            end_date=picker.endDate.format('DD/MM/YYYY');
            $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
            $dTable.draw();
        });

        $('#datesearch').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            start_date='';
            end_date='';
            $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
            $dTable.draw();
        });
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
        let url = "/registration/eventinternal/updatestatus/"+id_regis;
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