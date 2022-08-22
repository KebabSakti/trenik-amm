<x-layout>
    <x-slot:title>Tambah Jabatan</x-slot:title>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row card-body">
                    <div class="col-lg-5 col-12">
                        <form method="post" action="{{ route('jabatan.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Jabatan</label>
                                <input type="text" class="form-control" name="position_name"
                                    placeholder="Masukkan nama jabatan" required>
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
