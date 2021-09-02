@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('dosen.add')}}" class="btn btn-primary mb-3">Tambah Akun Mahasiswa</a>
                <table class="table table-bordered table-md" id="table-admin" style="width: 100%">
                    <thead>
                        <tr id="">
                            <th>No</th>
                            <th>Nama Dosen</th>
                            <th>NIDN</th>
                            <th>Program Studi</th>
                            <th>Nomor Telepon</th>
                            <th>Email</th>
                            <th>Photo</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dosens as $dosen)
                        <tr id="tr_{{$dosen->nim}}">
                            <td width="5%">{{$loop->iteration}}</td>
                            <td>
                                @if ($dosen->dosenRef)
                                    {{$dosen->dosenRef->dosen_lengkap_nama}}
                                @endif
                            </td>
                            <td>{{$dosen->nidn}}</td>
                            <td>
                                @if ($dosen->dosenRef)
                                    {{$dosen->dosenRef->program_studi_nama}}
                                @endif
                            </td>
                            <td>
                                {{$dosen->phone}}
                            </td>
                            <td>
                                {{$dosen->email}}
                            </td>
                            <td>
                                @if ($dosen->photo)
                                <img src="{{$dosen->photo_image_url}}"
                                    style="width: 50px; height:50px" alt="">
                                @else
                                <img style="width: 50px; height:50px"
                                    src="{{asset('assets/icons/pengguna_icon2.png')}}" alt="">
                                @endif
                            </td>
                            <td>{{ date("d/m/Y", strtotime($dosen->created_at)) }}</td>
                            <td>
                                <div class="btn-group dropleft">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-action">
                                        <a class="dropdown-item dropdown-action-item" href="{{route('dosen.edit', $dosen->nidn)}}"><i class="fas fa-pen-square mr-2"></i>Edit</a>
                                        <a class="dropdown-item dropdown-action-item" onclick="deleteDosen({{$dosen->nidn}})"href="#"><i class="fas fa-trash-alt mr-2"></i>Hapus</a>
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

{{-- upload inp --}}
<input type="file" name="" onchange="importDosen()" id="file-inp" class="d-none">
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
        var evalDate= parseDateValue(aData[7]);
       
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
        $.fn.dataTable.ext.classes.sPageButton = 'button button-primary';
        var $dTable = $('#table-admin').DataTable({
            responsive: true,
            "lengthChange": false,
            "dom":"<'row'<'col-lg-5'B ><'col-lg-3 col-12'f><'col-lg-4 col-12 ' <'datesearchbox'>>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'><'col-sm-7'p>>",
                buttons: [   
                    {
                        extend: 'excelHtml5',
                        title: 'Data Akun Dosen',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4, 5]
                        },
                        className:'btnExcel',
                        customize: function ( xlsx ) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            if(start_date != null && end_date != null){
                                convertStart(String(start_date));
                                convertEnd(String(end_date));
                                $('c[r=A1] t', sheet).text( 'Data Pengguna Dosen '+ start_month + " - "+ end_month);
                                $('row:first c', sheet).attr( 's', '51', '2' ); // first row is bold
                            }else{
                                $('c[r=A1] t', sheet).text( 'Data Pengguna Dosen');
                                $('row:first c', sheet).attr( 's', '51', '2' ); // first row is bold
                            }
                        }
                    },
                    {
                        text: 'Import',
                        className:'btnExcel',
                        action: function ( e, dt, node, config ) {
                            $('#file-inp').trigger('click');
                        }
                    }
                ],
                pagingType: "full_numbers",
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

    const deleteMahasiswa = (nim) => {
        console.log(nim);
        let url = "/mahasiswa/delete/"+nim;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Mahasiswa',
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
                            "nim": nim 
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                $('#tr_' + nim).remove();
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

    const importDosen = () => {
        var fd = new FormData();
        var files = $('#file-inp')[0].files;
        if(files.length > 0 ){
            fd.append('file',files[0]);
            Notiflix.Loading.Hourglass({ svgColor:"#327ec6", }); 
            $.ajax({
                url: '/dosen/import',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response.success){
                        Notiflix.Loading.Remove();
                        location.reload();
                    }else{
                        Notiflix.Notify.Failure(response.message);
                    }
                    
                },
                error:function(err){
                    Notiflix.Notify.Failure('Ooopss');
                },
            });
        }
    }
</script>
@endpush