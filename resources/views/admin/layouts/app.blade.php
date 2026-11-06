<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ড্যাশবোর্ড') | {{ $siteSettings['site_name'] ?? config('app.name', 'Akhitech') }} Admin</title>
    <link rel="shortcut icon" href="{{ !empty($siteSettings['favicon']) ? (str_starts_with($siteSettings['favicon'], 'http') ? $siteSettings['favicon'] : asset($siteSettings['favicon'])) : asset('assets/front/img/fav_icon_17368750061518442947.png') }}" type="image/png">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- CORE CSS -->
    <link rel="stylesheet" href="{{ asset('back-end/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back-end/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back-end/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back-end/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back-end/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back-end/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back-end/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back-end/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    @include('admin.layouts.partials.navbar')

    <!-- Main Sidebar Container -->
    @include('admin.layouts.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@yield('page_title', 'ড্যাশবোর্ড')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">এডমিন</a></li>
                            <li class="breadcrumb-item active">@yield('page_title', 'ড্যাশবোর্ড')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        <i class="fas fa-exclamation-triangle mr-1"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        <h5 class="alert-heading"><i class="fas fa-ban mr-1"></i> অনুগ্রহ করে ত্রুটিগুলো সংশোধন করুন:</h5>
                        <ul class="mb-0 pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; {{ date('Y') }} <a href="{{ route('home') }}">{{ config('app.name', 'Akhitech') }}</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Admin Panel</b>
        </div>
    </footer>
</div>

<!-- JQUERY & CORE JS -->
<script src="{{ asset('back-end/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('back-end/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('back-end/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('back-end/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('back-end/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('back-end/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- DATATABLES -->
<script src="{{ asset('back-end/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('back-end/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('back-end/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('back-end/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- ADMINLTE APP -->
<script src="{{ asset('back-end/dist/js/adminlte.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.summernote').summernote({
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });

        $('.data-table').DataTable({
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
        });

        // Client-side automatic logout after inactivity
        (function() {
            const timeoutMinutes = {{ (int) round(((int) config('auth.admin_idle_timeout', 3600)) / 60) }};
            const timeoutMs = timeoutMinutes * 60 * 1000;
            let idleTimer;

            function resetIdleTimer() {
                clearTimeout(idleTimer);
                idleTimer = setTimeout(function() {
                    alert('অলসতার কারণে (' + timeoutMinutes + ' মিনিট কোনো কার্যক্রম না থাকায়) আপনার সেশনটি স্বয়ংক্রিয়ভাবে বন্ধ করা হয়েছে।');
                    window.location.href = "{{ route('admin.login') }}";
                }, timeoutMs);
            }

            ['mousemove', 'mousedown', 'keypress', 'scroll', 'touchstart'].forEach(function(evt) {
                document.addEventListener(evt, resetIdleTimer, false);
            });

            resetIdleTimer();
        })();
    });
</script>

@stack('scripts')
</body>
</html>
