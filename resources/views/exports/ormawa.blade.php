<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Ormawa</th>
            <th>Nama Akronim</th>
            <th>Email</th>
            <th>Website</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ormawas as $ormawa)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$ormawa->nama_ormawa}}</td>
                <td>{{$ormawa->nama_akronim}}</td>
                <td>{{$ormawa->email}}</td>
                <td>{{$ormawa->website}}</td>
                @php
                    $created = \Carbon\Carbon::parse($ormawa->created_at);
                @endphp
                <td>{{$created->isoFormat('D MMMM Y')}}</td>
            </tr>
        @endforeach
    </tbody>
</table>