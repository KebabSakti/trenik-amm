<x-layout>
    <x-slot:title>Tambah Grade</x-slot:title>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row card-body">
                    <div class="col-lg-5 col-12">
                        <form method="post" action="{{ route('employee.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                                <small class="text-danger">* Digunakan untuk email login</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" class="form-control" name="nik" placeholder="NIK" required>
                                <small class="text-danger">* Digunakan untuk password login</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="employee_name"
                                    placeholder="Nama karyawan" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">KTP</label>
                                <input type="text" class="form-control" name="ktp" placeholder="KTP" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telp</label>
                                <input type="text" class="form-control" name="phone" placeholder="Telp" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Department</label>
                                <select name="department_id" class="form-select" required>
                                    <option value=""> - Pilih Department - </option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">
                                            {{ $department->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <select name="position_id" class="form-select" required>
                                    <option value=""> - Pilih Jabatan - </option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">
                                            {{ $position->position_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Grade</label>
                                <select name="grade_id" class="form-select" required>
                                    <option value=""> - Pilih Grade - </option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">
                                            {{ $grade->grade_name }}
                                            (Rp.{{ number_format($grade->max_credit, 2, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Level</label>
                                <select name="role" class="form-select" required>
                                    <option value=""> - Level Akun - </option>
                                    <option value="user">User (Normal User)</option>
                                    <option value="pic">PIC (Person In Charge)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">Status</div>
                                <label class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="active">
                                    <span class="form-check-label"></span>
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
