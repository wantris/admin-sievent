<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div style="width: 100%; margin-bottom:30px; text-align:center;">
        <h3>Data Peserta {{$event->nama_event}}</h3>
    </div>
    @if ($event->role == "Individu")
        <table style="width: 100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Program Studi</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th>Status Pendaftar</th>
                    <th>Status Validasi</th>
                    <th>Tahapan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendaftaran as $regis)
                    @php
                        $tahapan_count = count($regis->tahapan_regis_ref);
                    @endphp
                    <tr id="tr_{{$regis->id_event_eksternal_registration}}">
                        <td rowspan="{{$tahapan_count}}">{{$loop->iteration}}</td>
                        <td rowspan="{{$tahapan_count}}">
                            @if ($regis->mahasiswa_ref)
                                {{$regis->mahasiswa_ref->mahasiswa_nama}}
                            @else
                                {{$regis->nim}}
                            @endif
                        </td>
                        <td rowspan="{{$tahapan_count}}">
                            @if ($regis->mahasiswa_ref)
                                {{$regis->mahasiswa_ref->kelas_kode}}
                            @endif
                        </td>
                        <td rowspan="{{$tahapan_count}}">
                            @if ($regis->mahasiswa_ref)
                                {{$regis->mahasiswa_ref->program_studi_kode}}
                            @endif
                        </td>
                        <td rowspan="{{$tahapan_count}}">
                            {{$regis->pengguna_mhs_ref->email}}
                        </td>
                        <td rowspan="{{$tahapan_count}}">
                            {{$regis->pengguna_mhs_ref->phone}}
                        </td>
                        <td rowspan="{{$tahapan_count}}">
                            Mahasiswa Polindra
                        </td>
                        <td rowspan="{{$tahapan_count}}">
                            @if ($regis->status == "0")
                                Belum
                            @else
                                Tervalidasi
                            @endif
                        </td>
                        <td>
                            @if (count($regis->tahapan_regis_ref) > 0)
                                {{$regis->tahapan_regis_ref[0]->tahapan_event_eksternal->nama_tahapan}}
                            @endif
                        </td>
                    </tr>
                    @for($i=1;$i<$tahapan_count;$i++)
                        <tr>
                            <td>
                                @if (count($regis->tahapan_regis_ref) > 0)
                                    {{$regis->tahapan_regis_ref[$i]->tahapan_event_eksternal->nama_tahapan}}
                                @endif
                            </td>
                        </tr>
                    @endfor
                @endforeach
            </tbody>
        </table>
    @else
        <table style="width: 100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID Tim</th>
                    <th>Pembimbing</th>
                    <th>Keanggotaan</th>
                    <th>Kelas</th>
                    <th>Program Studi</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th>Status Validasi</th>
                    <th>Tahapan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendaftaran as $regis)
                    @php
                        $not_done = collect();
                        foreach ($regis->tim_ref->tim_detail_ref as $item) {
                            if ($item->status == "Done") {
                                $not_done->push($item);
                            }
                        }
                        $total_count = 0;
                        $detail_count = $not_done->count();
                        $tahapan_count = count($regis->tahapan_regis_ref);
                        if($detail_count > $tahapan_count){
                            $total_count = $detail_count;
                        }else{
                            $total_count =$tahapan_count;
                        }
                    @endphp
                    <tr id="tr_{{$regis->id_event_eksternal_registration}}">
                        <td rowspan="{{$total_count}}" valign="center">{{$loop->iteration}}</td>
                        <td rowspan="{{$total_count}}" valign="center">{{$regis->tim_event_id}}</td>
                        <td rowspan="{{$total_count}}" valign="center">
                            @if ($regis->tim_ref->pembimbing_ref)
                                {{$regis->tim_ref->pembimbing_ref->dosen_lengkap_nama}}
                            @else
                                {{$regis->tim_ref->nidn}}
                            @endif
                        </td>
                        <td valign="center">
                            @if ($regis->tim_ref->tim_detail_ref[0]->mahasiswa_ref)
                                {{$regis->tim_ref->tim_detail_ref[0]->mahasiswa_ref->mahasiswa_nama}}
                            @else
                                {{$regis->tim_ref->tim_detail_ref[0]->nim}}
                            @endif
                        </td>
                        <td valign="center">
                            @if ($regis->tim_ref->tim_detail_ref[0]->mahasiswa_ref)
                                {{$regis->tim_ref->tim_detail_ref[0]->mahasiswa_ref->kelas_kode}}
                            @endif
                        </td>
                        <td valign="center">
                            @if ($regis->tim_ref->tim_detail_ref[0]->mahasiswa_ref)
                                {{$regis->tim_ref->tim_detail_ref[0]->mahasiswa_ref->program_studi_kode}}
                            @endif
                        </td>
                        <td valign="center">
                            {{ucfirst($regis->tim_ref->tim_detail_ref[0]->role)}} 
                        </td>
                        <td valign="center">
                            {{$regis->tim_ref->tim_detail_ref[0]->pengguna_mhs_ref->email}} 
                        </td>
                        <td valign="center">
                            {{$regis->tim_ref->tim_detail_ref[0]->pengguna_mhs_ref->phone}} 
                        </td>
                        <td rowspan="{{$total_count}}" valign="center">
                            @if ($regis->status == "0")
                                Belum
                            @else
                                Tervalidasi
                            @endif
                        </td>
                        <td>
                            @if (count($regis->tahapan_regis_ref) > 0)
                                {{$regis->tahapan_regis_ref[0]->tahapan_event_eksternal->nama_tahapan}}
                            @endif
                        </td>
                    </tr>
                    @for($i=1;$i<$total_count;$i++)
                            <tr>
                                @if (!empty($regis->tim_ref->tim_detail_ref[$i]))
                                    @if ($regis->tim_ref->tim_detail_ref[$i]->status == "Done")
                                        <td valign="center">
                                            @if ($regis->tim_ref->tim_detail_ref[$i]->mahasiswa_ref)
                                                {{$regis->tim_ref->tim_detail_ref[$i]->mahasiswa_ref->mahasiswa_nama}}
                                            @else
                                                {{$regis->tim_ref->tim_detail_ref[$i]->nim}}
                                            @endif
                                        </td>
                                        <td valign="center">
                                            @if ($regis->tim_ref->tim_detail_ref[$i]->mahasiswa_ref)
                                                {{$regis->tim_ref->tim_detail_ref[$i]->mahasiswa_ref->kelas_kode}}
                                            @endif
                                        </td>
                                        <td valign="center">
                                            @if ($regis->tim_ref->tim_detail_ref[$i]->mahasiswa_ref)
                                                {{$regis->tim_ref->tim_detail_ref[$i]->mahasiswa_ref->program_studi_kode}}
                                            @endif
                                        </td>
                                        <td valign="center">
                                            {{ucfirst($regis->tim_ref->tim_detail_ref[$i]->role)}}
                                        </td>
                                        <td valign="center">
                                            {{$regis->tim_ref->tim_detail_ref[$i]->pengguna_mhs_ref->email}}
                                        </td>
                                        <td valign="center">
                                            {{$regis->tim_ref->tim_detail_ref[$i]->pengguna_mhs_ref->phone}}
                                        </td>
                                    @else
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @endif
                                @else
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endif
                                
                                @if (!empty($regis->tahapan_regis_ref[$i]))
                                    <td>
                                        @if (count($regis->tahapan_regis_ref) > 0)
                                            {{$regis->tahapan_regis_ref[$i]->tahapan_event_eksternal->nama_tahapan}}
                                        @endif
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                    @endfor
                @endforeach
            </tbody>
        </table> 
    @endif
</body>
</html>