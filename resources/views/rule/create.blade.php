<x-layout>
    <x-slot:title>Tambah Aturan Pengajuan</x-slot:title>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row card-body">
                    <div class="col-lg-5 col-12">
                        <form method="post" action="{{ route('rule.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Department Rule</label>
                                <select name="department_id" class="form-select" required>
                                    <option value="">- List Department -</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">
                                            {{ $department->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <button id="rule-add" type="button" class="btn btn-success">Tambah</button>
                            </div>
                            <div id="rule-container">
                                <div class="mb-3 rule-item">
                                    <label class="form-label">Department Approve</label>
                                    <div class="row">
                                        <div class="col-10">
                                            <select name="department_ids[]" class="form-select" required>
                                                <option value="">- List Department -</option>
                                                @foreach ($approvals as $approval)
                                                    <option value="{{ $approval->id }}">
                                                        {{ $approval->department_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-danger rule-del">Hapus</button>
                                        </div>
                                    </div>

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
