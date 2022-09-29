<x-layout>
    <x-slot:title>Data Koperasi</x-slot:title>

    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-5 col-12">
                        <form method="post" action="{{ route('company.update', $company->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nama Koperasi</label>
                                <input type="text" class="form-control" name="company_name"
                                    placeholder="Nama koperasi" value="{{ $company->company_name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Limit Bulanan</label>
                                <input type="number" min="0" class="form-control" name="monthly_balance"
                                    placeholder="Limit bulanan" value="{{ $company->monthly_balance }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">WA Admin Koperasi</label>
                                <input type="text" min="0" class="form-control" name="phone"
                                    placeholder="+6281254982664" value="{{ $company->phone }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Syarat dan Ketentuan</label>
                                <textarea name="tc" class="form-control" cols="30" rows="10">{{ $company->tc }}</textarea>
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
