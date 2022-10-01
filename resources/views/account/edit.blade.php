<x-layout>
    <x-slot:title>Edit Account</x-slot:title>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row card-body">
                    <div class="col-lg-5 col-12">
                        <form method="post" action="{{ route('account.update', $account->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Email"
                                    value="{{ $account->email }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password Lama</label>
                                <input type="password" class="form-control" name="password_lama"
                                    placeholder="Masukkan password lama" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-control" name="password_baru"
                                    placeholder="Masukkan password baru" required>
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