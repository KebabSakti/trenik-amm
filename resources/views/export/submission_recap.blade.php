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
    <h3 style="text-align: center; border:1px solid rgb(51, 51, 51); padding:6px;">REKAP PENGAJUAN KARYAWAN</h3>
    <br>
    <table>
        <thead>
            <tr>
                <td colspan="10" style="border: none; text-align: left; padding: 0px 0px 10px 0px;">
                    {{ Carbon\Carbon::now()->timezone('Asia/Kuala_Lumpur')->toDayDateTimeString() }}
                </td>
                <td colspan="3" style="border: none; text-align: right; padding: 0px 0px 10px 0px;">
                    {{ $company->company_name }}
                </td>
            </tr>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Karyawan</th>
                <th>Departemen</th>
                <th>NIK</th>
                <th>KTP</th>
                <th>No Hp</th>
                <th>Barang</th>
                <th>Harga</th>
                <th>Cicilan</th>
                <th>Bulanan</th>
                <th>Status</th>
                <th>Note Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $number = 1;
            @endphp
            @foreach ($submissions as $submission)
                <tr>
                    <td>{{ $number }}</td>
                    <td>
                        {{ Carbon\Carbon::parse($submission->created_at, 'UTC')->timezone('Asia/Kuala_Lumpur')->format('d/m/Y') }}
                    </td>
                    <td>{{ $submission->employee_name }}</td>
                    <td>{{ $submission->department_name }}</td>
                    <td>{{ $submission->nik }}</td>
                    <td>{{ $submission->ktp }}</td>
                    <td>{{ $submission->phone }}</td>
                    <td>
                        {{ $submission->product_name }}<br><br>
                        Catatan: {{ $submission->product_note ?? '-' }}
                    </td>
                    <td>Rp {{ number_format($submission->price, 2, ',', '.') }}</td>
                    <td>{{ $submission->count }}x</td>
                    <td>Rp {{ number_format($submission->credit, 2, ',', '.') }}</td>
                    <td>
                        @if ($submission->submission_status == 'pending')
                            <span style="color: orange;">
                                {{ Str::upper($submission->submission_status) }}
                            </span>
                        @endif

                        @if ($submission->submission_status == 'approved')
                            <span style="color: green;">
                                {{ Str::upper($submission->submission_status) }}
                            </span>
                        @endif

                        @if ($submission->submission_status == 'rejected')
                            <span style="color: red;">
                                {{ Str::upper($submission->submission_status) }}
                            </span>
                        @endif
                    </td>
                    <td>{{ $submission->status_note ?? '-' }}</td>

                </tr>

                @php
                    $number++;
                @endphp
            @endforeach
            <tr>
                <th colspan="8" style="font-weight: bold;">Total</th>
                <td colspan="2" style="font-weight: bold;">Rp
                    {{ number_format($submissions->sum('price'), 2, ',', '.') }}</td>
                <td colspan="3" style="font-weight: bold;">Rp
                    {{ number_format($submissions->sum('credit'), 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
