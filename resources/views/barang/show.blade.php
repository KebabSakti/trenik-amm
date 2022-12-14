<x-layout>
    <x-slot:title>Detail Barang</x-slot:title>

    <!-- Modal -->
    <x-modal-form>
        <x-slot:id>pengajuan-modal</x-slot:id>
        <x-slot:title>Form Pengajuan</x-slot:title>
        <form method="post" action="{{ route('submission.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" class="form-control" value="{{ $product->product_name }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Skema Kredit</label>
                <select name="credit_scheme_id" class="form-select" required>
                    <option value=""> - Pilih Cicilan - </option>
                    @foreach ($credit_schemes as $credit_scheme)
                        <option value="{{ $credit_scheme->id }}">
                            {{ $credit_scheme->count }}x | Harga : Rp
                            {{ number_format($credit_scheme->price, 2, ',', '.') }} | Bulanan : Rp
                            {{ number_format($credit_scheme->credit, 2, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Catatan Barang</label>
                <textarea class="form-control" name="product_note" placeholder="Warna, ukuran, varian dll.." rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Foto KTP</label>
                <input type="file" class="form-control" name="foto" placeholder="Foto" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mine Permit</label>
                <input type="file" class="form-control" name="permit" placeholder="Mine Permit" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Telp</label>
                <input type="text" class="form-control" name="phone" placeholder="No Telp" required>
            </div>
            <div class="mb-3">
                <label class="form-check">
                    <input class="form-check-input" type="checkbox" name="consent" required>
                    <span class="form-check-label">Saya setuju dengan <a
                            href="{{ route('company.show', Auth::user()->company_id) }}" target="_blank">Syarat &
                            Ketentuan</a></span>
                </label>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary">Buat Pengajuan</button>
            </div>
        </form>
    </x-modal-form>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row">
                        <div class="mb-3 me-3" style="max-width: 400px;">
                            <img src="{{ asset($product->product_image) }}" class="img-fluid">
                        </div>
                        <div>
                            @if (!$submitable)
                                <div class="alert alert-danger" role="alert">
                                    <h4 class="alert-title">Tidak Bisa Pengajuan Kredit</h4>
                                    <div class="text-muted">
                                        Anda memiliki cicilan yang belum selesai, atau anda memiliki pengajuan dengan
                                        status
                                        pending
                                    </div>
                                </div>
                            @endif
                            <h1>{{ $product->product_name }}</h1>
                            <h3>{{ $product->product_brand }}</h3>
                            <p>
                                {!! nl2br($product->product_description) !!}
                            </p>
                            @if (Auth::user()->role != 'admin')
                                <table class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cicilan</th>
                                            <th>Harga Jual</th>
                                            <th>Bulanan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($credit_schemes as $credit_scheme)
                                            <tr>
                                                <td>
                                                    {{ $credit_scheme->count }}x
                                                </td>
                                                <td>
                                                    Rp {{ number_format($credit_scheme->price, 2, ',', '.') }}
                                                </td>
                                                <td>
                                                    Rp {{ number_format($credit_scheme->credit, 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                            <a href="{{ url()->previous() }}" class="btn btn-warning">Kembali</a>
                            @if (Auth::user()->role != 'admin')
                                @if ($submitable)
                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#pengajuan-modal">Ajukan Cicilan</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
