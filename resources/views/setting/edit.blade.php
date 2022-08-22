<x-layout>
    <x-slot:title>Edit grade</x-slot:title>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body w-50">
                    <form method="post" action="{{ route('grade.update', $model->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Grade</label>
                            <input type="text" class="form-control" name="grade_name" placeholder="Masukkan nama grade"
                                value="{{ $model->grade_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Limit Pinjaman</label>
                            <input type="number" min="0" class="form-control" name="max_credit"
                                placeholder="Limit pinjaman" value="{{ $model->max_credit }}" required>
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
</x-layout>
