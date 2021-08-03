@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('pengguna.add')}}" class="btn btn-primary mb-5">Tambah pengguna</a>
                    <table class="table table-bordered table-md" id="table-admin" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Nomor Telepon</th>
                                <th>Email</th>
                                <th>Photo</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penggunas as $pengguna)
                            <tr id="tr_{{$pengguna->id_pengguna}}">
                                <td width="5%">{{$loop->iteration}}</td>
                                <td width="20%">{{$pengguna->username}}</td>
                                <td>
                                    {{$pengguna->phone}}
                                </td>
                                <td>
                                    {{$pengguna->email}}
                                </td>
                                <td>
                                    @if($pengguna->photo)
                                    <img src="{{ env('BACKEND_ASSET_URL') . "assets/img/photo-pengguna/".$pengguna->photo}}"
                                        style="width: 50px; height:50px" alt="">
                                    @else
                                    <img style="width: 50px; height:50px"
                                        src="{{asset('assets/icons/pengguna_icon.png')}}" alt="">
                                    @endif
                                </td>
                                <td> {{ date("d/m/Y", strtotime($pengguna->created_at)) }}</td>
                                <td>
                                    <a href="{{route('pengguna.edit', $pengguna->id_pengguna)}}"
                                        class="btn btn-secondary d-inline mb-2" title="Edit Akun"><i class="fas fa-pen-square"></i></a>
                                    <a href="#" onclick="deletepengguna({{$pengguna->id_pengguna}})"
                                        class="btn btn-danger mt-2 d-inline mb-2" title="Hapus"> <i class="far fa-trash-alt"></i></a>
                                    <a href="{{route('pengguna.relasi', $pengguna->id_pengguna)}}"
                                        class="btn btn-primary d-inline mb-2" title="Edit Relasi"> <i class="fas fa-atom"></i></a>
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
                    'colvis',    
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        },
                        customize: function ( xlsx ) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            if(start_date != null && end_date != null){
                                convertStart(String(start_date));
                                convertEnd(String(end_date));
                                $('c[r=A1] t', sheet).text( 'Data Event Internal '+ start_month + " - "+ end_month);
                                $('row:first c', sheet).attr( 's', '51', '2' ); // first row is bold
                            }else{
                                $('c[r=A1] t', sheet).text( 'Data Event Internal');
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
            $dTable.column(4).search(kategori).column(8).search(status).draw();   
        });

        $('#kategori-filter').on('change', function(){
            kategori = this.value;
            $dTable.column(4).search(kategori).column(8).search(status).draw();  
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

    const deletepengguna = (id_pengguna) => {
        let url = "/pengguna/delete/"+id_pengguna;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Pengguna',
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
                            "id_pengguna": id_pengguna 
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                $('#tr_' + id_pengguna).remove();
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
</script>
@endpush