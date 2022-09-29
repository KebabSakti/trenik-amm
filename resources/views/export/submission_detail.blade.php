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
            <th style="border: none;">
                <img src="{{ public_path('static/koperasi.png') }}" height="130">
            </th>
            <th style="line-height: 24px; border: none;">
                <div style="font-weight: bold; font-size: 20px;">
                    KOPERASI KARYAWAN PPA SEJAHTERA
                </div>
                <div style="font-size: 14px;">
                    Gedung Office 8, Lt.8 (SCBD lot 28) <br>
                    Jl. Senopati Raya, Rt.8/RW.3, Senayan, Kebayoran Baru, Jakarta Selatan <br>
                    Telp. (021) 57903457
                </div>
            </th>
        </tr>
    </table>
    <hr>
    <h3 style="text-align: center; border:1px solid rgb(51, 51, 51); padding:6px;">DETAIL PENGAJUAN</h3>
    <br>
    <table>
        <thead>
            <tr>
                <td colspan="5" style="border: none; text-align: left; padding: 0px 0px 10px 0px;">
                    {{ Carbon\Carbon::parse($submission->created_at, 'UTC')->timezone('Asia/Kuala_Lumpur')->toDayDateTimeString() }}
                </td>
                <td colspan="2" style="border: none; text-align: right; padding: 0px 0px 10px 0px;">
                    {{ $submission->company_name }}
                </td>
            </tr>
            <tr>
                <th>Karyawan</th>
                <th>Departemen</th>
                <th>NIK</th>
                <th>No Hp</th>
                <th>Barang</th>
                <th>Skema</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $submission->employee_name }}</td>
                <td>{{ $submission->department_name }}</td>
                <td>{{ $submission->nik }}</td>
                <td>{{ $submission->phone }}</td>
                <td>
                    {{ $submission->product_name }}<br><br>
                    Catatan: {{ $submission->product_note ?? '-' }}
                </td>
                <td>
                    Cicilan : {{ $submission->count }}x <br>
                    Harga : Rp {{ number_format($submission->price, 2, ',', '.') }} <br>
                    Bulanan : Rp {{ number_format($submission->credit, 2, ',', '.') }}
                </td>
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
            </tr>
            <tr>
                <th>Catatan</th>
                <td colspan="6">
                    {{ $submission->status_note }}
                </td>
            </tr>
        </tbody>
    </table>
    <br><br>
    <div style="text-align: center; margin-top:10px; font-size: 12px;">
        @foreach ($approvals as $approval)
            <div style="display: inline-block; margin:10px;">
                {{ $approval['employee_name'] ?? $approval['department_name'] }}
                <br><br>
                @if ($approval['status'] == 'pending')
                    <span style="color: orange;">
                        {{ Str::upper($approval['status']) }}
                    </span>
                @endif

                @if ($approval['status'] == 'approved')
                    <span style="color: green;">
                        {{ Str::upper($approval['status']) }}
                    </span>
                @endif

                @if ($approval['status'] == 'rejected')
                    <span style="color: red;">
                        {{ Str::upper($approval['status']) }}
                    </span>
                @endif
                <br><br>
                {{ Carbon\Carbon::parse($approval['updated_at'], 'UTC')->timezone('Asia/Kuala_Lumpur')->toDayDateTimeString() }}
                <br>
                (DEPARTEMEN {{ Str::upper($approval['department_name']) }})
            </div>
        @endforeach
    </div>
</body>

</html>
