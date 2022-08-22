<x-layout>
    <x-slot:title>Edit Barang</x-slot:title>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row card-body">
                    <div class="col-md-5 col-12">
                        <form method="post" action="{{ route('product.update', $model->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" name="product_name" placeholder="Nama barang"
                                    value="{{ $model->product_name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Merk Barang</label>
                                <input type="text" class="form-control" name="product_brand" placeholder="Nama merk"
                                    required value="{{ $model->product_brand }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="file" placeholder="Gambar barang">
                                @if ($model->product_image)
                                    <a data-fancybox href="{{ asset($model->product_image) }}">Lihat Gambar</a>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Barang</label>
                                <textarea type="text" class="form-control" name="product_description" placeholder="Deskripsi barang" rows="10">{{ $model->product_description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">Status Barang</div>
                                <label class="form-check form-switch">
                                    @php
                                        $checked = $model->active == 1 ? 'checked' : '';
                                    @endphp
                                    <input class="form-check-input" type="checkbox" name="active" {{ $checked }}>
                                </label>
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
