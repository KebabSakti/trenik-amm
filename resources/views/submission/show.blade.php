<x-layout>
    <x-slot:title>Detail Pengajuan</x-slot:title>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="table-default" class="table-responsive">
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-title">Pengajuan Belum Di Setujui</h4>
                            <div class="text-muted">
                                Pengajuan anda belum disetujui oleh departemen yang bersangkutan
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Cicilan</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Tanggal Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($credits as $credit)
                                        @php
                                            $paid = $credit->paid ? 'PAID' : 'UNPAID';
                                        @endphp
                                        <tr>
                                            <td>{{ $credit->month }}</td>
                                            <td>{{ number_format($credit->amount, 2, ',', '.') }}</td>
                                            <td>{{ $paid }}</td>
                                            <td>
                                                {{ Carbon::parse($credit->updated_at, 'UTC')->timezone('Asia/Kuala_Lumpur')->toDayDateTimeString() }}
                                            </td>
                                        </tr>
                                    @endforeach
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
