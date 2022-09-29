<x-layout>
    <x-slot:title>Detail Cicilan</x-slot:title>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="table-default" class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-hover table-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Cicilan</th>
                                        <th>Total</th>
                                        <th>Jadwal Bayar</th>
                                        <th>Update Terakhir</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($credits) == 0)
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data cicilan</td>
                                        </tr>
                                    @else
                                        @foreach ($credits as $credit)
                                            @php
                                                $paid = $credit->paid ? '<span class="badge rounded-pill text-bg-success">PAID</span>' : '<span class="badge rounded-pill text-bg-warning">UNPAID</span>';
                                            @endphp
                                            <tr>
                                                <td>{{ $credit->month }}</td>
                                                <td>Rp {{ number_format($credit->amount, 2, ',', '.') }}</td>
                                                <td>
                                                    {{ Carbon\Carbon::parse($credit->billed_at, 'UTC')->timezone('Asia/Kuala_Lumpur')->toFormattedDateString() }}
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse($credit->updated_at, 'UTC')->timezone('Asia/Kuala_Lumpur')->toDayDateTimeString() }}
                                                </td>
                                                <td>{!! $paid !!}</td>
                                            </tr>
                                        @endforeach

                                    @endif

                                </tbody>
                            </table>
                            <a href="{{ url()->previous() }}" class="btn btn-warning mt-2">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
