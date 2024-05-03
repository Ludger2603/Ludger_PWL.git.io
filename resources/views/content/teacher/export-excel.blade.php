<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Tanggal Lahir</th>
        <th>Umur</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i =1;
    @endphp
    @foreach($rows as $teacher)
        <tr>
            <td>{{$i++}}</td>
            <td>{{$teacher->name}}</td>
            <td>{{$teacher->email}}</td>
            <td>{{$teacher->dob}}</td>
            <td>{{$teacher->age}} Tahun</td>
        </tr>
    @endforeach
    </tbody>
</table>

