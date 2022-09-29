<x-layout>
    <x-slot:title>List Pengajuan</x-slot:title>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (Auth::user()->role == 'admin')
                        <div class="row mb-2">
                            <div class="col-12 col-md-3 mb-2">
                                <input type="text" name="daterange" class="form-control">
                            </div>
                            <div class="col-12 col-md-2">
                                <form method="post" action="{{ route('submission_recap') }}" target="_blank">
                                    @csrf
                                    <input type="hidden" name="start_date_list_pengajuan"
                                        value="{{ Carbon\Carbon::now()->startOfYear() }}">
                                    <input type="hidden" name="end_date_list_pengajuan"
                                        value="{{ Carbon\Carbon::now()->endOfYear() }}">
                                    <button type="submit" class="btn btn-danger w-100">PDF</a>
                                </form>
                            </div>
                            <div class="col-12 col-md-2">
                                <form method="post" action="{{ route('excel_submission_recap') }}" target="_blank">
                                    @csrf
                                    <input type="hidden" name="start_date_list_pengajuan"
                                        value="{{ Carbon\Carbon::now()->startOfYear() }}">
                                    <input type="hidden" name="end_date_list_pengajuan"
                                        value="{{ Carbon\Carbon::now()->endOfYear() }}">
                                    <button type="submit" class="btn btn-success w-100">Excel</a>
                                </form>
                            </div>
                        </div>
                    @endif

                    <div id="table-default" class="table-responsive">
                        <div class="table-responsive">
                            <table id="picapprove-table" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Karyawan</th>
                                        <th>Department</th>
                                        <th>NIK</th>
                                        <th>Telp</th>
                                        <th>Barang</th>
                                        <th>Status</th>
                                        <th>Tanggal Ajuan</th>
                                        <th>Update Terakhir</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
