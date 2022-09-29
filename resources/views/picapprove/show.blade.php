<x-layout>
    <x-slot:title>Detail Pengajuan</x-slot:title>

    <!-- Modal -->
    <x-modal-form>
        <x-slot:id>edit-barang-modal</x-slot:id>
        <x-slot:title>List Barang</x-slot:title>
        <div id="table-default" class="table-responsive">
            <div class="table-responsive">
                <table class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Cicilan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prcts as $prct)
                            <tr>
                                <td>{{ $prct['product_name'] }}</td>
                                <td>
                                    @foreach ($prct['scheme'] as $credit_scheme)
                                        <div class="d-flex justify-content-between mb-2">
                                            <div>
                                                {{ $credit_scheme->count }}x | Harga : Rp
                                                {{ number_format($credit_scheme->price, 2, ',', '.') }} | Bulanan : Rp
                                                {{ number_format($credit_scheme->credit, 2, ',', '.') }}
                                            </div>
                                            <form method="post"
                                                action="{{ route('picapprove.update', $submission->id) }}"
                                                style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="product_id"
                                                    value="{{ $prct['product_id'] }}">
                                                <input type="hidden" name="credit_scheme_id"
                                                    value="{{ $credit_scheme->id }}">
                                                <button class="btn btn-sm btn-primary" type="submit">Pilih Cicilan</a>
                                            </form>
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-modal-form>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row card-body">
                    <div class="col-lg-6 col-12">
                        <form method="post" action="{{ route('picapprove.update', $submission->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nama Karyawan</label>
                                <input type="text" class="form-control" value="{{ $submission->employee_name }}"
                                    disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" class="form-control" value="{{ $submission->nik }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" class="form-control" value="{{ $submission->position_name }}"
                                    disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Department</label>
                                <input type="text" class="form-control" value="{{ $submission->department_name }}"
                                    disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Hp</label>
                                <input type="text" class="form-control" value="{{ $submission->phone }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No KTP</label>
                                <input type="text" class="form-control" value="{{ $submission->ktp }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lampiran</label>
                                <a class="badge rounded-pill text-bg-primary" data-fancybox
                                    href="{{ asset($submission->foto_ktp) }}">KTP</a>
                                <a class="badge rounded-pill text-bg-primary" data-fancybox
                                    href="{{ asset($submission->foto_permit) }}">MINE PERMIT</a>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kredit</label>
                                <div class="d-flex">
                                    <input type="text" class="form-control flex-fill"
                                        value=" {{ $submission->product_name }} | {{ $submission->count }}x | Harga : Rp {{ number_format($submission->price, 2, ',', '.') }} | Bulanan : Rp {{ number_format($submission->credit, 2, ',', '.') }}"
                                        disabled>
                                    @if (Auth::user()->role == 'admin')
                                        <div class="mx-1"></div>
                                        <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#edit-barang-modal">Edit</a>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan Barang</label>
                                <textarea class="form-control" rows="3" name="product_note" disabled>{{ $submission->product_note }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status Pengajuan</label>
                                @foreach ($rules as $rule)
                                    @if ($rule['status'] == 'approved')
                                        <a class="btn btn-pill btn-success" href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-circle-check" width="28"
                                                height="28" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <circle cx="12" cy="12" r="9"></circle>
                                                <path d="M9 12l2 2l4 -4"></path>
                                            </svg>
                                            {{ Str::upper($rule['department_name']) }} (APPROVED)
                                        </a>
                                    @endif

                                    @if ($rule['status'] == 'rejected')
                                        <a class="btn btn-pill btn-danger" href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-circle-x" width="28"
                                                height="28" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <circle cx="12" cy="12" r="9"></circle>
                                                <path d="M10 8l4 8"></path>
                                                <path d="M10 16l4 -8"></path>
                                            </svg>
                                            {{ Str::upper($rule['department_name']) }} (REJECTED)
                                        </a>
                                    @endif

                                    @if ($rule['status'] == 'pending')
                                        <a class="btn btn-pill btn-warning" href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-alert-circle" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <circle cx="12" cy="12" r="9"></circle>
                                                <line x1="12" y1="8" x2="12" y2="12">
                                                </line>
                                                <line x1="12" y1="16" x2="12.01" y2="16">
                                                </line>
                                            </svg>
                                            {{ Str::upper($rule['department_name']) }} (PENDING)
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                            @if ($submission->submission_status == 'rejected')
                                <div class="mb-3">
                                    <label class="form-label">Catatan Pengajuan</label>
                                    <textarea class="form-control" rows="3" disabled>{{ $submission->status_note }}</textarea>
                                </div>
                            @endif
                            @if (Auth::user()->role == 'pic' && $mApproval == null)
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label">Pengajuan</label>
                                    <select name="status" class="form-select">
                                        <option value="rejected">REJECT</option>
                                        <option value="approved">APPROVE</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Catatan</label>
                                    <textarea class="form-control" name="note" rows="3" placeholder="Catatan"></textarea>
                                </div>
                            @endif
                            <div class="form-footer">
                                <a href="{{ url()->previous() }}" class="btn btn-warning">Batal</a>
                                @if (Auth::user()->role == 'pic' && $mApproval == null)
                                    <button type="submit" class="btn btn-primary btn-submit confirm">Submit</button>
                                @endif
                                <a href="{{ route('submission_detail', $submission->id) }}" class="btn btn-info"
                                    target="_blank">Export PDF</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
