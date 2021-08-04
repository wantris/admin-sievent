@extends('app')

@push('style')

@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-lg-3 col-12">
                        <select name="event" id="event-select" class="form-control">
                            <option value="">Semua Event</option>
                            @foreach ($events as $event)
                                <option value="{{$event->nama_event}}">{{$event->nama_event}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    <table class="table table-bordered nowrap" id="table-admin" style="width:100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>No</th>
                                <th>ID Tim</th>
                                <th>Pembimbing</th>
                                <th>Nama Event</th>
                                <th>Ketua Tim</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tims as $tim)
                                <tr id="tr_{{$tim->id_tim_event}}">
                                    <td></td>
                                    <td width="5%">{{$loop->iteration}}</td>
                                    <td>{{$tim->id_tim_event}}</td>
                                    <td>
                                        @if ($tim->dosen_ref)
                                            {{$tim->dosen_ref->dosen_lengkap_nama}}
                                        @else
                                            {{$tim->nidn}}
                                        @endif
                                    </td>
                                    <td>{{$tim->event_internal_regis_ref->event_internal_ref->nama_event}}</td>
                                    <td>
                                        @foreach ($tim->tim_detail_ref as $detail)
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
                                    <td>
                                        @if ($tim->status == "1")
                                            Tervalidasi
                                        @else
                                            Tidak Valid
                                        @endif
                                    </td>
                                    <td> {{ date("d/m/Y", strtotime($tim->created_at)) }}</td>
                                    <td>
                                        @php
                                            $tim_detail_json = json_encode($tim->tim_detail_ref);
                                        @endphp
                                        <div class="btn-group dropleft">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu dropdown-action">
                                                <a class="dropdown-item dropdown-action-item" onclick="detailTim({{$tim_detail_json}})" href="#"><i class="fas fa-eye mr-2"></i>Detail</a>
                                                @if ($tim->status == "1")
                                                    <a class="dropdown-item dropdown-action-item"  onclick="updateStatus({{$tim->id_tim_event}}, '0')" href="#"><i class="fas fa-ban"></i>Buat Tidak Tervalidasi</a>
                                                @else
                                                    <a class="dropdown-item dropdown-action-item"  onclick="updateStatus({{$tim->id_tim_event}}, '1')" href="#"><i class="fas fa-check-circle-2"></i>Buat Tervalidasi</a>
                                                @endif
                                                <a class="dropdown-item dropdown-action-item" onclick="deleteTim({{$tim->id_tim_event}})" href="#"><i class="fas fa-trash-alt mr-2"></i>Hapus</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
        var $dTable = $('#table-admin').DataTable({
            responsive: true,
            "dom":"<'row'<'col-sm-3'l>B<'col-sm-3' <'datesearchbox'>><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [     
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        },
                        className:'btnExcel',
                        customize: function ( xlsx ) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            if(start_date != null && end_date != null){
                                convertStart(String(start_date));
                                convertEnd(String(end_date));
                                $('c[r=A1] t', sheet).text( 'Data Partisipan '+ start_month + " - "+ end_month);
                                $('row:first c', sheet).attr( 's', '51', '2' ); // first row is bold
                            }else{
                                $('c[r=A1] t', sheet).text( 'Data Partisipan');
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
        });

        $('#modal-body-detail').html(html);
    }

    const deleteTim = (id_tim) => {
        let url = "/team/delete/"+id_tim;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Tim',
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

    const updateStatus = (id_tim, status) => {
        let url = "/team/updatestatus/"+id_tim;
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