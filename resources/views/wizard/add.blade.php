<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Sign in - Tronik AMM</title>
    <!-- Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ env('APP_PATH') . 'static/favicon.ico' }}" />
    <!-- CSS files -->
    <link href="{{ env('APP_PATH') . 'dist/css/tabler.min.css' }}" rel="stylesheet" />
    <link href="{{ env('APP_PATH') . 'dist/css/tabler-flags.min.css' }}" rel="stylesheet" />
    <link href="{{ env('APP_PATH') . 'dist/css/tabler-payments.min.css' }}" rel="stylesheet" />
    <link href="{{ env('APP_PATH') . 'dist/css/tabler-vendors.min.css' }}" rel="stylesheet" />
    <link href="{{ env('APP_PATH') . 'dist/css/demo.min.css' }}" rel="stylesheet" />
</head>

<body class="border-top-wide border-primary d-flex flex-column">
    <div class="page page-center">
        <div class="container-tight py-4">
            <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark"><img
                        src="{{ env('APP_PATH') . 'static/logo-top.png' }}" height="140" alt=""></a>
            </div>
            <form class="card card-md" action="{{ session('wizard_session') }}" method="post">
                @csrf
                <div class="card-body">
                    <h2 class="mb-3 text-center text-muted">Akses Admin</h2>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" placeholder="Password" required>
                    </div>
                    <h2 class="my-3 text-center text-muted">Data Site</h2>
                    <div class="mb-3">
                        <label class="form-label">Nama Koperasi</label>
                        <input name="company_name" type="text" class="form-control"
                            placeholder="Koperasi AMM Site Handil" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No WA Admin Koperasi</label>
                        <input name="phone" type="text" class="form-control" placeholder="+6281254982664" required>
                        <small class="text-danger">* Gunakan kode wilayah (+62) pada no WA contoh +6281254982664</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Limit Per Bulan</label>
                        <input name="monthly_balance" type="number" class="form-control" placeholder="150.000.000"
                            min="0" required>
                        <small class="text-danger">* di reset otomatis tiap bulan</small>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Daftar</button>
                    </div>
                </div>
            </form>

            @if ($errors->any())
                <x-alert>
                    <x-slot:type>alert-danger</x-slot>
                        <x-slot:title>Error</x-slot>
                            {{ $errors->first() }}
                </x-alert>
            @endif
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ env('APP_PATH') . 'dist/js/tabler.min.js' }}" defer></script>
    <script src="{{ env('APP_PATH') . 'dist/js/demo.min.js' }}" defer></script>
</body>

</html>
