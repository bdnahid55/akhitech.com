<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteSettings['site_name'] ?? config('app.name', 'Akhitech') }} Admin | লগইন</title>
    <link rel="shortcut icon" href="{{ !empty($siteSettings['favicon']) ? (str_starts_with($siteSettings['favicon'], 'http') ? $siteSettings['favicon'] : asset($siteSettings['favicon'])) : asset('assets/front/img/fav_icon_17368750061518442947.png') }}" type="image/png">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('back-end/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('back-end/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page bg-light">
<div class="login-box">
    <div class="card card-outline card-primary shadow">
        <div class="card-header text-center">
            <a href="{{ route('home') }}" class="h2 font-weight-bold text-dark">
                <b>{{ $siteSettings['site_name'] ?? config('app.name', 'Akhitech') }}</b> Admin
            </a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">এডমিন প্যানেলে প্রবেশ করতে লগইন করুন</p>

            @if (session('error'))
                <div class="alert alert-danger py-2 px-3 mb-3">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="ইমেইল এড্রেস" value="{{ old('email') }}" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="পাসওয়ার্ড" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row align-items-center mb-3">
                    <div class="col-8">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">মনে রাখুন</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">লগইন</button>
                    </div>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('home') }}" class="text-muted"><i class="fas fa-arrow-left mr-1"></i> ওয়েবসাইটে ফিরে যান</a>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('back-end/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('back-end/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('back-end/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
