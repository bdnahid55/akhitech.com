@extends('admin.layouts.app')

@section('title', 'এসইও সাইটম্যাপ ম্যানেজমেন্ট')
@section('page_title', 'এসইও সাইটম্যাপ (XML Sitemap)')

@section('content')
    <div class="row">
        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        {{-- Overview Banner --}}
        <div class="col-12">
            <div class="callout callout-info shadow-sm bg-white">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div>
                        <h5 class="text-info font-weight-bold mb-1">
                            <i class="fas fa-sitemap mr-1"></i> ডায়নামিক ও স্ট্যাটিক সাইটম্যাপ স্ট্যাটাস
                        </h5>
                        <p class="mb-2 text-muted">
                            আপনার ওয়েবসাইটের সাইটম্যাপটি স্বয়ংক্রিয়ভাবে ডায়নামিক (Dynamic)। যখনই কোনো নতুন পেজ, পোর্টফোলিও বা ব্লগ পোস্ট প্রকাশ করা হয়, সার্চ ইঞ্জিন ক্রলাররা (Googlebot, Bingbot) রিয়েল-টাইমে তা পেয়ে যায়। এছাড়া দ্রুত লোডিং ও উচ্চ পারফরম্যান্সের জন্য আপনি এক ক্লিকেই সর্বশেষ ডেটা দিয়ে ফিজিক্যাল <code>sitemap.xml</code> ফাইল জেনারেট বা রিফ্রেশ করতে পারেন।
                        </p>
                        <div class="d-flex align-items-center flex-wrap">
                            <span class="mr-2 font-weight-bold text-dark">লাইভ সাইটম্যাপ লিঙ্ক:</span>
                            <a href="{{ $status['url'] }}" target="_blank" class="badge badge-light border px-2 py-1 text-primary font-weight-bold" style="font-size: 0.95rem;">
                                {{ $status['url'] }} <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="mt-3 mt-md-0 text-md-right">
                        @can('settings.edit')
                            <form action="{{ route('admin.sitemap.generate') }}" method="POST" class="d-inline" onsubmit="this.querySelector('button').disabled = true;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg shadow-sm font-weight-bold">
                                    <i class="fas fa-sync-alt mr-1"></i> সাইটম্যাপ জেনারেট / আপডেট করুন
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info shadow-sm">
                <div class="inner">
                    <h3>{{ $status['total_urls'] }}</h3>
                    <p class="font-weight-bold">মোট ইনডেক্সড URL</p>
                </div>
                <div class="icon">
                    <i class="fas fa-link"></i>
                </div>
                <div class="small-box-footer">সাইটম্যাপে মোট লিঙ্ক সংখ্যা</div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success shadow-sm">
                <div class="inner">
                    <h3>{{ $status['breakdown']['static'] }}</h3>
                    <p class="font-weight-bold">স্ট্যাটিক পেজসমূহ</p>
                </div>
                <div class="icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="small-box-footer">হোম, এবাউট, সার্ভিস, যোগাযোগ ইত্যাদি</div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning shadow-sm">
                <div class="inner">
                    <h3>{{ $status['breakdown']['pages'] }}</h3>
                    <p class="font-weight-bold text-white">কাস্টম ডায়নামিক পেজ</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="small-box-footer text-white">অ্যাক্টিভ কাস্টম পেজসমূহ</div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-purple shadow-sm" style="background-color: #6f42c1 !important; color: white;">
                <div class="inner">
                    <h3>{{ $status['breakdown']['portfolios'] + $status['breakdown']['posts'] }}</h3>
                    <p class="font-weight-bold">ব্লগ ও পোর্টফোলিও</p>
                </div>
                <div class="icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="small-box-footer text-white">প্রজেক্ট ও পাবলিশড আর্টিকেল</div>
            </div>
        </div>

        {{-- File Details & Actions Card --}}
        <div class="col-12">
            <div class="card card-outline card-secondary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">
                        <i class="fas fa-server mr-1"></i> সাইটম্যাপ ফাইল ও কনফিগারেশন বিবরণ
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.sitemap.download') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download mr-1"></i> sitemap.xml ডাউনলোড
                        </a>
                        <a href="{{ $status['url'] }}" target="_blank" class="btn btn-sm btn-outline-primary ml-1">
                            <i class="fas fa-external-link-alt mr-1"></i> সরাসরি দেখুন
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <span class="text-muted d-block">ফাইল স্ট্যাটাস:</span>
                            @if ($status['exists'])
                                <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> ফাইল বিদ্যমান (Active)</span>
                            @else
                                <span class="badge badge-warning px-2 py-1"><i class="fas fa-clock mr-1"></i> অন-ডিমান্ড ডায়নামিক মোড</span>
                            @endif
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <span class="text-muted d-block">সর্বশেষ জেনারেট / আপডেট:</span>
                            <strong class="text-dark">{{ $status['last_generated_at'] ? \Carbon\Carbon::parse($status['last_generated_at'])->format('d M, Y - h:i A') : 'এখনও ফাইল জেনারেট করা হয়নি' }}</strong>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <span class="text-muted d-block">ফাইলের আকার (File Size):</span>
                            <strong class="text-dark">{{ $status['file_size'] }}</strong>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <span class="text-muted d-block">সার্ভার পাথ:</span>
                            <code class="text-break" style="font-size: 0.85rem;">{{ $status['file_path'] }}</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- URLs Table --}}
        <div class="col-12">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                    <h3 class="card-title font-weight-bold mb-2 mb-sm-0">
                        <i class="fas fa-list-ul mr-1"></i> সাইটম্যাপে অন্তর্ভুক্ত সমস্ত URLs ({{ count($entries) }})
                    </h3>
                    <div class="card-tools">
                        <input type="text" id="sitemapSearchInput" class="form-control form-control-sm" placeholder="URL বা পেজের নাম দিয়ে ফিল্টার করুন..." style="width: 250px;">
                    </div>
                </div>
                <div class="card-body table-responsive p-0" style="max-height: 520px;">
                    <table class="table table-hover table-striped text-nowrap" id="sitemapTable">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>পেজের শিরোনাম / নাম</th>
                                <th>URL লিঙ্ক</th>
                                <th>ধরন (Type)</th>
                                <th>প্রায়োরিটি</th>
                                <th>ফ্রিকোয়েন্সি</th>
                                <th>সর্বশেষ আপডেট</th>
                                <th class="text-center" style="width: 90px;">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($entries as $index => $entry)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="font-weight-bold text-dark">{{ $entry['name'] }}</td>
                                    <td>
                                        <a href="{{ $entry['url'] }}" target="_blank" class="text-primary">
                                            {{ $entry['url'] }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($entry['type'] === 'static')
                                            <span class="badge badge-secondary">স্ট্যাটিক</span>
                                        @elseif ($entry['type'] === 'page')
                                            <span class="badge badge-info">কাস্টম পেজ</span>
                                        @elseif ($entry['type'] === 'portfolio')
                                            <span class="badge badge-primary">পোর্টফোলিও</span>
                                        @elseif ($entry['type'] === 'post')
                                            <span class="badge badge-success">ব্লগ পোস্ট</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-light border font-weight-bold">{{ $entry['priority'] }}</span>
                                    </td>
                                    <td>
                                        <code class="text-muted">{{ $entry['changefreq'] }}</code>
                                    </td>
                                    <td class="text-muted">{{ $entry['lastmod'] }}</td>
                                    <td class="text-center">
                                        <a href="{{ $entry['url'] }}" target="_blank" class="btn btn-xs btn-outline-info" title="পেজটি ভিজিট করুন">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">কোনো URL পাওয়া যায়নি।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Search Console Guidelines --}}
        <div class="col-12">
            <div class="card card-outline card-info shadow-sm">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">
                        <i class="fab fa-google mr-1"></i> গুগল ও অন্যান্য সার্চ ইঞ্জিনে সাইটম্যাপ সাবমিশন
                    </h3>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        আপনার সাইট সার্চ ইঞ্জিনে দ্রুত ইনডেক্স করানোর জন্য গুগল সার্চ কনসোল ও বিং ওয়েবমাস্টার টুলে সাইটম্যাপ সাবমিট করুন:
                    </p>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="p-3 border rounded bg-light">
                                <h6 class="font-weight-bold text-primary mb-1">
                                    <i class="fab fa-google mr-1"></i> Google Search Console
                                </h6>
                                <p class="text-muted small mb-2">Google Search Console-এ লগইন করে "Sitemaps" সেকশনে যান এবং শুধুমাত্র <code>sitemap.xml</code> লিখে সাবমিট করুন।</p>
                                <a href="https://search.google.com/search-console" target="_blank" class="btn btn-xs btn-primary font-weight-bold">
                                    গুগল সার্চ কনসোল ওপেন করুন <i class="fas fa-external-link-alt ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="p-3 border rounded bg-light">
                                <h6 class="font-weight-bold text-info mb-1">
                                    <i class="fab fa-microsoft mr-1"></i> Bing Webmaster Tools
                                </h6>
                                <p class="text-muted small mb-2">Bing Webmasters-এ লগইন করে "Sitemaps" মেন্যুতে সম্পূর্ণ URL (<code>{{ $status['url'] }}</code>) সাবমিট করুন।</p>
                                <a href="https://www.bing.com/webmasters" target="_blank" class="btn btn-xs btn-info font-weight-bold text-white">
                                    বিং ওয়েবমাস্টার ওপেন করুন <i class="fas fa-external-link-alt ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('sitemapSearchInput');
            const table = document.getElementById('sitemapTable');
            const rows = table.querySelectorAll('tbody tr');

            if (searchInput) {
                searchInput.addEventListener('keyup', function () {
                    const query = this.value.toLowerCase().trim();

                    rows.forEach(function (row) {
                        const text = row.textContent.toLowerCase();
                        if (text.includes(query)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
@endpush
