<x-layout>
    <x-slot:title>Tambah Grade</x-slot:title>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row card-body">
                    <div class="col-lg-5 col-12">
                        <form method="post" action="{{ route('grade.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Grade</label>
                                <input type="text" class="form-control" name="grade_name"
                                    placeholder="Masukkan nama grade" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Limit Pinjaman</label>
                                <input type="number" min="0" class="form-control" name="max_credit"
                                    placeholder="Limit pinjaman" required>
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
