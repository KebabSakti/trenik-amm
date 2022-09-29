<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Email</th>
            <th>Nama</th>
            <th>NIK</th>
            <th>KTP</th>
            <th>Telp</th>
            <th>Department</th>
            <th>Jabatan</th>
            <th>Grade</th>
            <th>Limit Pinjaman</th>
            <th>Level</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp

        @foreach ($employees as $employee)
            @php
                $status = $employee->active == 1 ? 'AKTIF' : 'NON AKTIF';
            @endphp

            <tr>
                <td>{{ $no }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->employee_name }}</td>
                <td>{{ $employee->nik }}</td>
                <td>{{ $employee->ktp }}</td>
                <td>{{ $employee->phone }}</td>
                <td>{{ $employee->department_name }}</td>
                <td>{{ $employee->position_name }}</td>
                <td>{{ $employee->grade_name }}</td>
                <td>{{ $employee->max_credit }}</td>
                <td>{{ $employee->role }}</td>
                <td>{{ $status }}</td>
            </tr>

            @php
                $no++;
            @endphp
        @endforeach
    </tbody>
</table>
