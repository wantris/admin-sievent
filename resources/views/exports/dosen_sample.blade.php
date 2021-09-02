<table >
    <thead>
        <tr>
            <th>No</th>
            <th>NIDN</th>
            <th>Nama Dosen</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dosens as $key => $dosen)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>
                    {{$dosen->dosen_nidn}}
                </td>
                <td>
                    {{$dosen->dosen_gelar_depan . " " . $dosen->dosen_nama . " " . $dosen->dosen_gelar_belakang}}
                </td>
            </tr>
        @endforeach

    </tbody>
</table>