<x-layout>
    <x-slot:title>Edit Karyawan</x-slot:title>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row card-body">
                    <div class="col-lg-5 col-12">
                        <form method="post" action="{{ route('employee.update', $employee->user_id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email"
                                    value="{{ $employee->email }}" required>
                                <small class="text-danger">* Digunakan untuk email login</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password">
                                <small class="text-danger">* Kosongkan jika tidak mengganti password</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" class="form-control" name="nik" placeholder="NIK"
                                    value="{{ $employee->nik }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="employee_name"
                                    placeholder="Nama karyawan" value="{{ $employee->employee_name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">KTP</label>
                                <input type="text" class="form-control" name="ktp" placeholder="KTP"
                                    value="{{ $employee->ktp }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telp</label>
                                <input type="text" class="form-control" name="phone" placeholder="Telp"
                                    value="{{ $employee->phone }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Department</label>
                                <select name="department_id" class="form-select" required>
                                    <option value=""> - Pilih Department - </option>
                                    @foreach ($departments as $department)
                                        @php
                                            $selected = $employee->department_id == $department->id ? 'selected' : '';
                                        @endphp

                                        <option value="{{ $department->id }}" {{ $selected }}>
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
                                        @php
                                            $selected = $employee->position_id == $position->id ? 'selected' : '';
                                        @endphp

                                        <option value="{{ $position->id }}" {{ $selected }}>
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
                                        @php
                                            $selected = $employee->grade_id == $grade->id ? 'selected' : '';
                                        @endphp

                                        <option value="{{ $grade->id }}" {{ $selected }}>
                                            {{ $grade->grade_name }}
                                            (Rp.{{ number_format($grade->max_credit, 2, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Level</label>
                                <select name="role" class="form-select" required>
                                    @php
                                        $roles = [
                                            [
                                                'key' => 'user',
                                                'value' => 'User (Normal User)',
                                            ],
                                            [
                                                'key' => 'pic',
                                                'value' => 'PIC (Person In Charge)',
                                            ],
                                        ];
                                    @endphp

                                    <option value=""> - Level Akun - </option>
                                    @foreach ($roles as $role)
                                        @php
                                            $selected = $employee->role == $role['key'] ? 'selected' : '';
                                        @endphp

                                        <option value="{{ $role['key'] }}" {{ $selected }}>
                                            {{ $role['value'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">Status</div>
                                <label class="form-check form-switch">
                                    @php
                                        $checked = $employee->active == 1 ? 'checked' : '';
                                    @endphp

                                    <input class="form-check-input" type="checkbox" name="active" {{ $checked }}>
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
