<!--============================
    HEADER START
=============================-->
<header>
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-md-8 d-none d-md-block">
                <ul class="header_info d-flex flex-wrap">
                    @if (!empty($siteSettings['contact_phone']))
                        <li>
                            <a href="tel:{{ $siteSettings['contact_phone'] }}"><i class="fas fa-phone-alt"></i> {{ $siteSettings['contact_phone'] }}</a>
                        </li>
                    @endif
                    @if (!empty($siteSettings['contact_email']))
                        <li>
                            <a href="mailto:{{ $siteSettings['contact_email'] }}"><i class="fas fa-envelope"></i> {{ $siteSettings['contact_email'] }}</a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="col-xl-4 col-md-4">
                <ul class="header_icon d-flex flex-wrap">
                    @php
                        $fb = $siteSettings['social_facebook'] ?? $siteSettings['facebook_url'] ?? null;
                        $tw = $siteSettings['social_twitter'] ?? $siteSettings['twitter_url'] ?? null;
                        $in = $siteSettings['social_instagram'] ?? $siteSettings['instagram_url'] ?? null;
                        $li = $siteSettings['social_linkedin'] ?? $siteSettings['linkedin_url'] ?? null;
                        $yt = $siteSettings['social_youtube'] ?? $siteSettings['youtube_url'] ?? null;
                    @endphp
                    @if (!empty($fb))
                        <li><a href="{{ $fb }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                    @endif
                    @if (!empty($tw))
                        <li><a href="{{ $tw }}" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-twitter"></i></a></li>
                    @endif
                    @if (!empty($in))
                        <li><a href="{{ $in }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a></li>
                    @endif
                    @if (!empty($li))
                        <li><a href="{{ $li }}" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
                    @endif
                    @if (!empty($yt))
                        <li><a href="{{ $yt }}" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</header>
<!--============================
    HEADER END
=============================-->

<!--============================
    MENU START
=============================-->
<nav class="navbar navbar-expand-lg main_menu">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ !empty($siteSettings['header_logo']) ? (str_starts_with($siteSettings['header_logo'], 'http') ? $siteSettings['header_logo'] : asset($siteSettings['header_logo'])) : asset('assets/front/img/header_logo_17368734951488188050.png') }}" alt="{{ $siteSettings['site_name'] ?? config('app.name', 'Akhitech') }}" class="img-fluid w-100">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="far fa-bars menu_bar_icon"></i>
            <i class="far fa-times menu_close_icon"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">হোম</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">আমাদের সম্পর্কে</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('services*') ? 'active' : '' }}" href="{{ route('services') }}">সার্ভিস</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('portfolio*') ? 'active' : '' }}" href="{{ route('portfolio') }}">পোর্টফোলিও</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('blog*') ? 'active' : '' }}" href="{{ route('blog') }}">ব্লগ</a>
                </li>

                <!-- Dynamic Header Pages Dropdown -->
                @if (isset($headerPages) && $headerPages->isNotEmpty())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('page/*') ? 'active' : '' }}" href="#">পেইজ +</a>
                        <ul class="droap_menu">
                            @foreach ($headerPages as $page)
                                <li>
                                    <a class="{{ request()->is('page/'.$page->slug) ? 'active' : '' }}" href="{{ route('page.show', $page->slug) }}">
                                        {{ $page->title }}
                                    </a>
                                </li>
                                @if ($page->children && $page->children->isNotEmpty())
                                    @foreach ($page->children as $child)
                                        <li>
                                            <a class="pl-4 {{ request()->is('page/'.$child->slug) ? 'active' : '' }}" href="{{ route('page.show', $child->slug) }}">
                                                &nbsp;&nbsp;↳ {{ $child->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">যোগাযোগ</a>
                </li>
            </ul>
            <ul class="right_menu d-flex flex-wrap align-items-center">
                <li>
                    <a class="common_btn" href="{{ route('quote') }}">ফ্রি কনসালটেশন</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--============================
    MENU END
=============================-->
