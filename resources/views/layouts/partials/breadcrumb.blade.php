<!--============================
    BREADCRUMB START
=============================-->
<section class="breadcrumb_area" style="background: url({{ asset('assets/frontend/images/breadcrumb_bg.jpg') }}) no-repeat center/cover;">
    <div class="breadcrumb_overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_text">
                        <h1>{{ $title ?? ($siteSettings['site_name'] ?? config('app.name', 'Akhitech')) }}</h1>
                        <ul>
                            <li><a href="{{ route('home') }}">হোম</a></li>
                            @if(isset($subtitle))
                                <li><a href="#">{{ $subtitle }}</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
    BREADCRUMB END
=============================-->
