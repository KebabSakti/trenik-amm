<x-layout>
    <x-slot:title>Tambah Skema Kredit</x-slot:title>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row card-body">
                    <div class="col-md-5 col-12">
                        <form method="post" action="{{ route('credit_scheme.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <select class="form-select" name="product_id">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @for ($i = 1; $i <= 12; $i > 1 ? ($i += 3) : ($i += 2))
                                <input type="hidden" name="counts[]" value="{{ $i }}">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label">Harga Jual</label>
                                        <input type="number" min="0" class="form-control" name="prices[]"
                                            placeholder="Harga jual" required>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Cicilan {{ $i }}x</label>
                                        <input type="number" min="0" class="form-control" name="credits[]"
                                            placeholder="Cicilan {{ $i }}x" required>
                                    </div>
                                </div>
                            @endfor
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
