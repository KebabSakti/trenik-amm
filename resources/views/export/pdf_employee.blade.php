<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export PDF</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
        }

        table td,
        table th {
            border: 1px solid rgb(51, 51, 51);
            padding: 8px;
        }

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            color: rgb(51, 51, 51);
        }

        hr {
            border: 1px solid rgb(51, 51, 51);
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th style="width: 170px; border: none;">
                <img src="{{ public_path('static/koperasi.png') }}" height="150">
            </th>
            <th style="line-height: 28px; border: none;">
                <div style="font-weight: bold; font-size: 24px;">
                    KOPERASI KARYAWAN PPA SEJAHTERA
                </div>
                <div style="font-size: 18px;">
                    Gedung Office 8, Lt.8 (SCBD lot 28) <br>
                    Jl. Senopati Raya, Rt.8/RW.3, Senayan, Kebayoran Baru, Jakarta Selatan <br>
                    Telp. (021) 57903457
                </div>
            </th>
        </tr>
    </table>
    <hr>
    <h3 style="text-align: center; border:1px solid rgb(51, 51, 51); padding:6px;">DATA KARYAWAN</h3>
    <br>
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
                    <td>Rp {{ number_format($employee->max_credit, 2, ',', '.') }}</td>
                    <td>{{ $employee->role }}</td>
                    <td>{{ $status }}</td>
                </tr>

                @php
                    $no++;
                @endphp
            @endforeach
        </tbody>
    </table>
</body>

</html>
