<table >
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Program Studi</th>
            <th>Nidn</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($wadir3s as $wadir3)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>@if ($wadir3->dosenRef)
                    {{ucwords($wadir3->dosenRef->dosen_lengkap_nama)}}
                @endif
            </td>
            <td>
                @if ($wadir3->dosenRef)
                    {{ucwords($wadir3->dosenRef->program_studi_nama)}}
                @endif
            </td>
            <td>{{$wadir3->nidn}}</td>
            <td>
                @if ($wadir3->status == "1")
                    Aktif
                @else
                    Tidak Aktif
                @endif
            </td>
            <td>{{$wadir3->created_at->isoFormat('D MMMM Y')}}</td>
        </tr>
        @endforeach

    </tbody>
</table>