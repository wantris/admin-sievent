
<table style="width: 100%">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Kegiatan</th>
            <th>Nama</th>
            <th>Program Studi</th>
            <th>Tingkatan</th>
            <th>Posisi Juara</th>
            <th>Prestasi yang dicapai</th>
            <th>Sertifikat</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($prestasis as $pendaftaran)
            @foreach ($pendaftaran as $regis)
                @if ($regis->event_internal_ref->role == "Individu")
                    @if ($regis->nim)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$regis->event_internal_ref->nama_event}}</td>
                            <td>
                                @if ($regis->mahasiswa_ref)
                                    {{$regis->mahasiswa_ref->mahasiswa_nama}}
                                @else
                                    {{$regis->nim}}
                                @endif
                            </td>
                            <td>
                                @if ($regis->mahasiswa_ref)
                                    {{$regis->mahasiswa_ref->program_studi_kode}}
                                @endif
                            </td>
                            <td>Nasional</td>
                            <td>
                                Juara {{$regis->prestasi_ref->posisi}}
                            </td>
                            <td>{{$regis->prestasi_ref->catatan}}</td>
                            <td>
                                @if ($regis->sertifikat_ref)
                                    {{env('BACKEND_URL')."eventinternal/sertificate/". $regis->sertifikat_ref->filename}}
                                @endif
                            </td>
                        </tr>
                    @endif                    
                @else
                    @php
                        $done = collect();
                        foreach ($regis->tim_ref->tim_detail_ref as $item) {
                            if ($item->status == "Done" && $item->nim) {
                                $done->push($item);
                            }
                        }
                        $count = $done->count();
                    @endphp
                    <tr>
                        <td rowspan="{{$count}}" valign="center">{{$no++}}</td>
                        <td rowspan="{{$count}}" valign="center">{{$regis->event_internal_ref->nama_event}}</td>
                        <td>
                            @if ($regis->tim_ref->tim_detail_ref[0]->mahasiswa_ref)
                                {{$regis->tim_ref->tim_detail_ref[0]->mahasiswa_ref->mahasiswa_nama}}
                            @else
                                {{$regis->tim_ref->tim_detail_ref[0]->nim}}
                            @endif
                        </td>
                        <td>
                            @if ($regis->tim_ref->tim_detail_ref[0]->mahasiswa_ref)
                                {{$regis->tim_ref->tim_detail_ref[0]->mahasiswa_ref->program_studi_kode}}
                            @endif
                        </td>
                        <td rowspan="{{$count}}" valign="center">Nasional</td>
                        <td rowspan="{{$count}}" valign="center">Juara {{$regis->prestasi_ref->posisi}}</td>
                        <td rowspan="{{$count}}" valign="center">{{$regis->prestasi_ref->catatan}}</td>
                        <td rowspan="{{$count}}" valign="center">
                            @if ($regis->sertifikat_ref)
                                {{env('BACKEND_URL')."eventinternal/sertificate/". $regis->sertifikat_ref->filename}}
                            @endif
                        </td>
                    </tr>
                    @for($i=1;$i<$count;$i++)
                        @if (!empty($regis->tim_ref->tim_detail_ref[$i]))
                            @if ($regis->tim_ref->tim_detail_ref[$i]->status == "Done" && $regis->tim_ref->tim_detail_ref[$i]->nim)
                                <tr>
                                    <td>
                                        @if ($regis->tim_ref->tim_detail_ref[$i]->mahasiswa_ref)
                                            {{$regis->tim_ref->tim_detail_ref[$i]->mahasiswa_ref->mahasiswa_nama}}
                                        @else
                                            {{$regis->tim_ref->tim_detail_ref[$i]->nim}}
                                        @endif
                                    </td>
                                    <td >
                                        @if ($regis->tim_ref->tim_detail_ref[0]->mahasiswa_ref)
                                            {{$regis->tim_ref->tim_detail_ref[0]->mahasiswa_ref->program_studi_kode}}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endfor
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>

