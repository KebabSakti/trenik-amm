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
            <form class="card card-md" action="login/authenticate" method="post">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Password
                            {{-- <span class="form-label-description">
                                <a href="#">Lupa password</a>
                            </span> --}}
                        </label>
                        <div class="input-group input-group-flat">
                            <input name="password" type="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
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

            @if (session('alert'))
                <x-alert>
                    <x-slot:type>alert-info</x-slot>
                        <x-slot:title>Info</x-slot>
                            {{ session('alert') }}
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
