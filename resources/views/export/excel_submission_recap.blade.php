<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Karyawan</th>
            <th>Departemen</th>
            <th>NIK</th>
            <th>KTP</th>
            <th>No Hp</th>
            <th>Barang</th>
            <th>Note Barang</th>
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
                <td>{{ $submission->product_name }}</td>
                <td>{{ $submission->product_note ?? '-' }}</td>
                <td>{{ $submission->price }}</td>
                <td>{{ $submission->count }}x</td>
                <td>{{ $submission->credit }}</td>
                <td>
                    @if ($submission->submission_status == 'pending')
                        {{ Str::upper($submission->submission_status) }}
                    @endif

                    @if ($submission->submission_status == 'approved')
                        {{ Str::upper($submission->submission_status) }}
                    @endif

                    @if ($submission->submission_status == 'rejected')
                        {{ Str::upper($submission->submission_status) }}
                    @endif
                </td>
                <td>{{ $submission->status_note ?? '-' }}</td>
            </tr>

            @php
                $number++;
            @endphp
        @endforeach
    </tbody>
</table>
