<x-layout>
    <x-slot:title>Edit Skema Kredit</x-slot:title>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row card-body">
                    <div class="col-lg-5 col-12">
                        <form method="post" action="{{ route('credit_scheme.update', $product->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <select class="form-select" name="product_id">
                                    <option value="{{ $product->id }}" selected>
                                        {{ $product->product_name }}
                                    </option>
                                </select>
                            </div>
                            @for ($i = 0; $i < count($credit); $i++)
                                <input type="hidden" name="ids[]" value="{{ $credit[$i]->id }}">
                                <input type="hidden" name="counts[]" value="{{ $credit[$i]->count }}">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label">Harga Jual</label>
                                        <input type="number" min="0" class="form-control" name="prices[]"
                                            placeholder="Harga jual" value="{{ $credit[$i]->price }}" required>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Cicilan {{ $credit[$i]->count }}x</label>
                                        <input type="number" min="0" class="form-control" name="credits[]"
                                            placeholder="Cicilan {{ $credit[$i]->count }}x"
                                            value="{{ $credit[$i]->credit }}" required>
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
