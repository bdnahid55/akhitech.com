<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- SEO Meta Tags -->
    @php
        $defaultTitle = ($siteSettings['default_meta_title'] ?? '') ?: (($siteSettings['site_name'] ?? config('app.name', 'Akhitech')) . ' | ' . ($siteSettings['site_tagline'] ?? 'আইটি সল্যুশন ও সফটওয়্যার সার্ভিস'));
        $pageTitle = trim($__env->yieldContent('title'));
        $metaTitle = trim($__env->yieldContent('meta_title'));
        $titleToDisplay = $metaTitle ?: ($pageTitle ? $pageTitle . ' | ' . ($siteSettings['site_name'] ?? config('app.name', 'Akhitech')) : $defaultTitle);
        $metaDescription = trim($__env->yieldContent('meta_description')) ?: ($siteSettings['default_meta_description'] ?? 'আখিটেকে স্বাগতম - নির্ভরযোগ্য ওয়েব ডেভেলপমেন্ট, সফটওয়্যার ও ডিজিটাল আইটি সেবা প্রদানকারী প্রতিষ্ঠান।');
        $metaKeywords = trim($__env->yieldContent('meta_keywords')) ?: ($siteSettings['default_meta_keywords'] ?? 'web development, software development, it services bd, laravel');
        $canonicalUrl = trim($__env->yieldContent('canonical_url')) ?: url()->current();
        $ogImage = trim($__env->yieldContent('og_image')) ?: (!empty($siteSettings['default_og_image']) ? (str_starts_with($siteSettings['default_og_image'], 'http') ? $siteSettings['default_og_image'] : asset($siteSettings['default_og_image'])) : asset('assets/front/img/breadcrumb_image_.png'));
    @endphp

    <title>{{ $titleToDisplay }}</title>
    <meta name="description" content="{{ $metaDescription }}" />
    <meta name="keywords" content="{{ $metaKeywords }}" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <link rel="canonical" href="{{ $canonicalUrl }}" />
    @if (!empty($siteSettings['google_search_console_code']))
        <meta name="google-site-verification" content="{{ $siteSettings['google_search_console_code'] }}" />
    @endif

    <!-- Open Graph (Facebook / WhatsApp / LinkedIn) -->
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:site_name" content="{{ $siteSettings['site_name'] ?? config('app.name', 'Akhitech') }}" />
    <meta property="og:title" content="{{ $titleToDisplay }}" />
    <meta property="og:description" content="{{ $metaDescription }}" />
    <meta property="og:url" content="{{ $canonicalUrl }}" />
    <meta property="og:image" content="{{ $ogImage }}" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $titleToDisplay }}" />
    <meta name="twitter:description" content="{{ $metaDescription }}" />
    <meta name="twitter:image" content="{{ $ogImage }}" />

    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="{{ !empty($siteSettings['favicon']) ? (str_starts_with($siteSettings['favicon'], 'http') ? $siteSettings['favicon'] : asset($siteSettings['favicon'])) : asset('assets/front/img/fav_icon_17368750061518442947.png') }}" type="image/png" />

    <!-- JSON-LD Schema.org Structured Data -->
    <script type="application/ld+json">
    {
      "{{ '@' }}context": "https://schema.org",
      "@type": "Organization",
      "name": "{{ $siteSettings['site_name'] ?? config('app.name', 'Akhitech') }}",
      "url": "{{ url('/') }}",
      "logo": "{{ !empty($siteSettings['header_logo']) ? (str_starts_with($siteSettings['header_logo'], 'http') ? $siteSettings['header_logo'] : asset($siteSettings['header_logo'])) : asset('assets/front/img/header_logo_17368734951488188050.png') }}",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "{{ $siteSettings['contact_phone'] ?? '+8801849832178' }}",
        "contactType": "Customer Support",
        "email": "{{ $siteSettings['contact_email'] ?? 'info@akhitech.com' }}"
      },
      "sameAs": [
        "{{ $siteSettings['social_facebook'] ?? '#' }}",
        "{{ $siteSettings['social_twitter'] ?? '#' }}",
        "{{ $siteSettings['social_linkedin'] ?? '#' }}",
        "{{ $siteSettings['social_youtube'] ?? '#' }}"
      ]
    }
    </script>

    @if (!empty($siteSettings['google_analytics_id']))
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteSettings['google_analytics_id'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $siteSettings['google_analytics_id'] }}');
        </script>
    @endif

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/venobox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/animated_barfiller.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/utilities.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css') }}" />

    <style>
        .single_blog_img a {
            position: static !important;
            padding: 0 !important;
            background: transparent !important;
            border-radius: 0 !important;
            display: block !important;
            width: 100% !important;
        }
        .single_blog_img img {
            width: 100% !important;
            height: 250px !important;
            object-fit: cover !important;
            display: block !important;
        }

        /* Service Item Equal Height & Hover Space */
        .services .row > [class*='col-'],
        .services_page .row > [class*='col-'] {
            display: flex !important;
            flex-direction: column !important;
        }

        .service_item {
            min-height: 400px !important;
            height: calc(100% - 25px) !important;
            display: flex !important;
            flex-direction: column !important;
            padding: 30px 22px 25px 22px !important;
        }

        .service_item .icon {
            width: 75px !important;
            height: 75px !important;
            line-height: 75px !important;
            font-size: 26px !important;
            flex-shrink: 0 !important;
        }

        .service_item h2 {
            min-height: 56px !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            font-size: 22px !important;
            line-height: 1.3 !important;
            margin-top: 20px !important;
            margin-bottom: 12px !important;
            flex-shrink: 0 !important;
        }

        .service_item p {
            min-height: 72px !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 3 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            font-size: 15px !important;
            line-height: 24px !important;
            margin-bottom: 20px !important;
        }

        .service_item:hover a {
            bottom: 25px !important;
        }

        .service_item:hover p {
            margin-bottom: 20px !important;
        }

        @media (max-width: 575.99px) {
            .project_item {
                height: 280px !important;
                margin-top: 20px !important;
            }
            .project_item img,
            .project_item > a > img {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
                display: block !important;
            }
            .project_item_text {
                height: auto !important;
                max-height: 85% !important;
                padding: 15px !important;
                opacity: 1 !important;
                background: linear-gradient(0deg, rgba(9, 9, 25, 0.95) 0%, rgba(9, 9, 25, 0.75) 70%, transparent 100%) !important;
                flex-wrap: nowrap !important;
            }
            .project_item_text span {
                font-size: 12px !important;
                padding: 5px 14px !important;
                margin-bottom: 6px !important;
            }
            .project_item_text h3 {
                font-size: 16px !important;
                line-height: 1.3 !important;
                margin-top: 5px !important;
                margin-bottom: 8px !important;
                display: -webkit-box !important;
                -webkit-line-clamp: 2 !important;
                -webkit-box-orient: vertical !important;
                overflow: hidden !important;
            }
            .project_item_text a {
                font-size: 13px !important;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    @include('layouts.partials.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    <!-- Scripts -->
    <script src="{{ asset('assets/frontend/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/Font-Awesome.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/venobox.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.marquee.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/animated_barfiller.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/sticky_sidebar.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.countup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>

    @stack('scripts')
</body>
</html>
