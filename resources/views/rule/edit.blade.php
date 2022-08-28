<x-layout>
    <x-slot:title>Edit Aturan Pengajuan</x-slot:title>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row card-body">
                    <div class="col-lg-5 col-12">
                        <form method="post" action="{{ route('rule.update', $rule->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Department Rule</label>
                                <input type="text" class="form-control" name="department_id"
                                    placeholder="Nama department" value="{{ $rule->department_name }}" readonly>
                            </div>
                            @foreach ($rule_details as $rule_detail)
                                <div id="rule-item-id" class="mb-3 rule-item">
                                    <label class="form-label">Department Approve</label>
                                    <select name="department_ids[]" class="form-select" required>
                                        <option value="">- List Department -</option>
                                        @foreach ($departments as $department)
                                            @php
                                                $selected = $rule_detail->department_id == $department->id ? 'selected' : '';
                                            @endphp

                                            <option value="{{ $department->id }}" {{ $selected }}>
                                                {{ $department->department_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
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
