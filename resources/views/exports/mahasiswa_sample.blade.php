<table >
    <thead>
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mahasiswas as $key => $mahasiswa)
            @if ($key <= 30)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        {{$mahasiswa->mahasiswa_nim}}
                    </td>
                    <td>
                        {{$mahasiswa->mahasiswa_nama}}
                    </td>
                </tr>
            @endif
        @endforeach

    </tbody>
</table>