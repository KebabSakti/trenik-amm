<x-layout>
    <x-slot:title>Edit Barang</x-slot:title>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row card-body">
                    <div class="col-lg-5 col-12">
                        <form method="post" action="{{ route('credit_scheme.update', $credit->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <select class="form-select" name="product_id">
                                    <option value="{{ $credit->product_id }}" selected>
                                        {{ $credit->product_name }}
                                    </option>
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">Harga Jual</label>
                                    <input type="number" min="0" class="form-control" name="price_1x"
                                        placeholder="Harga jual" value="{{ $credit->price_1x }}" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">Cicilan 1x</label>
                                    <input type="number" min="0" class="form-control" name="credit_1x"
                                        placeholder="Cicilan 1x" value="{{ $credit->credit_1x }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">Harga Jual</label>
                                    <input type="number" min="0" class="form-control" name="price_3x"
                                        placeholder="Harga jual" value="{{ $credit->price_3x }}" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">Cicilan 3x</label>
                                    <input type="number" min="0" class="form-control" name="credit_3x"
                                        placeholder="Cicilan 3x" value="{{ $credit->credit_3x }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">Harga Jual</label>
                                    <input type="number" min="0" class="form-control" name="price_6x"
                                        placeholder="Harga jual" value="{{ $credit->price_6x }}" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">Cicilan 6x</label>
                                    <input type="number" min="0" class="form-control" name="credit_6x"
                                        placeholder="Cicilan 6x" value="{{ $credit->credit_6x }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">Harga Jual</label>
                                    <input type="number" min="0" class="form-control" name="price_9x"
                                        placeholder="Harga jual" value="{{ $credit->price_9x }}" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">Cicilan 9x</label>
                                    <input type="number" min="0" class="form-control" name="credit_9x"
                                        placeholder="Cicilan 9x" value="{{ $credit->credit_9x }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">Harga Jual</label>
                                    <input type="number" min="0" class="form-control" name="price_12x"
                                        placeholder="Harga jual" value="{{ $credit->price_12x }}" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">Cicilan 12x</label>
                                    <input type="number" min="0" class="form-control" name="credit_12x"
                                        placeholder="Cicilan 12x" value="{{ $credit->credit_12x }}" required>
                                </div>
                            </div>
                            <div class="form-footer">
                                <a href="{{ url()->previous() }}" class="btn btn-warning">Batal</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
