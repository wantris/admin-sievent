@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('eventeksternal.add')}}" class="btn btn-primary mb-4">Tambah Event Eksternal</a>
                <div class="row mb-5">
                    <div class="col-lg-3 col-12">
                        <select class="form-control" id="kategori-filter">
                            <option selected value="">Filter Kategori</option>
                            @foreach ($kategoris as $kategori)
                            <option value="{{$kategori->nama_kategori}}">{{$kategori->nama_kategori}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-12">
                        <select class="form-control" id="status-filter">
                            <option value="">Pilih Status</option>
                            <option value="Terverifikasi">Terverifikasi</option>
                            <option value="Invalid">Invalid</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-12">
                        <select class="form-control" id="ormawa-filter">
                            <option value="">Pilih Ormawa</option>
                            @foreach ($ormawas as $ormawa)
                                <option value="{{$ormawa->nama_ormawa}}">{{$ormawa->nama_ormawa}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <table class="table table-bordered table-md" id="table-admin" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Event</th>
                            <th>Nama Ormawa</th>
                            <th>Tipe Peserta</th>
                            <th>Kategori</th>
                            <th>Role</th>
                            <th>Tanggal Buka</th>
                            <th>Tanggal Tutup</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                        <tr id="tr_{{$event->id_event_eksternal}}">
                            <td width="5%">{{$loop->iteration}}</td>
                            <td width="25%">{{$event->nama_event}}</td>
                            <td width="20%">{{$event->cakupan_ormawa_ref->role}}</td>
                            <td>{{$event->tipe_peserta_ref->nama_tipe}}</td>
                            <td>{{$event->kategori_ref->nama_kategori}}</td>
                            <td>{{$event->role}}</td>
                            <td>
                                @php
                                $tglbuka = Carbon\Carbon::parse($event->tgl_buka)->toDatetime()->format('d, M
                                Y');
                                @endphp
                                {{$tglbuka}}
                            </td>
                            <td>
                                @php
                                $tgltutup = Carbon\Carbon::parse($event->tgl_tutup)->toDatetime()->format('d, M
                                Y');
                                @endphp
                                {{$tgltutup}}
                            </td>
                            <td>
                                @if ($event->status == 1)
                                <span class="badge badge-pill badge-success">Terverifikasi</span>
                                @else
                                <span class="badge badge-pill badge-danger">Invalid</span>
                                @endif
                            </td>
                            <td>
                                {{ date("d/m/Y", strtotime($event->created_at)) }}
                            </td>
                            <td width="40%">
                                <div class="btn-group dropleft">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-action">
                                        <a class="dropdown-item dropdown-action-item" href="{{route('eventeksternal.edit', $event->id_event_eksternal)}}"><i class="fas fa-pen-square mr-2"></i>Edit</a>
                                        <a class="dropdown-item dropdown-action-item" onclick="deleteEvent({{$event->id_event_eksternal}})" href="#"><i class="fas fa-trash-alt mr-2"></i>Hapus</a>
                                        <a class="dropdown-item dropdown-action-item" href="{{route('eventeksternal.pengajuan', $event->id_event_eksternal)}}"><i class="fas fa-book-open mr-2"></i>Lihat Pengajuan</a>
                                        <a class="dropdown-item dropdown-action-item" href="{{route('registrations.eventeksternal.getbyevent', $event->id_event_eksternal)}}"><i class="fas fa-users mr-2"></i>Lihat Pendaftar</a>
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
        var evalDate= parseDateValue(aData[9]);
       
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
        var ormawa = $('#ormawa-filter').val();
        var $dTable = $('#table-admin').DataTable({
            responsive:"true",
            "lengthChange": false,
            "dom":"<'row'<'col-lg-5'B ><'col-lg-3 col-12'f><'col-lg-4 col-12 ' <'datesearchbox'>>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'><'col-sm-7'p>>",
                buttons: [    
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8,9]
                        },
                        className:'btnExcel',
                        customize: function ( xlsx ) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            if(start_date != null && end_date != null){
                                convertStart(String(start_date));
                                convertEnd(String(end_date));
                                $('c[r=A1] t', sheet).text( 'Data Event Eksternal '+ ormawa+ ' '+ start_month + " - "+ end_month);
                                $('row:first c', sheet).attr( 's', '51', '2' ); // first row is bold
                            }else{
                                $('c[r=A1] t', sheet).text( 'Data Event Eksternal '+ormawa);
                                $('row:first c', sheet).attr( 's', '51', '2' ); // first row is bold
                            }
                        }
                    }
                ],
        });

        new $.fn.dataTable.FixedHeader( $dTable );

        let status = '';
        let kategori = '';

        $('#status-filter').on('change', function(){
            status = this.value;
            $dTable.column(8).search(status).draw();   
        });

        $('#kategori-filter').on('change', function(){
            kategori = this.value;
            $dTable.column(4).search(kategori).draw();  
        });

        $('#ormawa-filter').on('change', function(){
            ormawa = this.value;
            $dTable.column(2).search(ormawa).draw();  
        });

        //menambahkan daterangepicker di dalam datatables
        $("div.datesearchbox").html('<div class="input-group mb-3"> <div class="input-group-addon"> <i class="glyphicon glyphicon-calendar"></i> </div><input type="text" class="form-control pull-right" id="datesearch" placeholder="Berdasarkan tanggal.."> </div>');

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

    const deleteEvent = (id_eventeksternal) => {
        let url = "/eventeksternal/delete/"+id_eventeksternal;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Event eksternal',
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
                            "id_eventeksternal": id_eventeksternal
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                $('#tr_' + id_eventeksternal).remove();
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