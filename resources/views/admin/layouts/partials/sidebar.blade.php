<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link text-center">
        <span class="brand-text font-weight-light font-weight-bold">{{ $siteSettings['site_name'] ?? config('app.name', 'Akhitech') }} Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>ড্যাশবোর্ড</p>
                    </a>
                </li>

                <li class="nav-header">কনটেন্ট ম্যানেজমেন্ট</li>

                <li class="nav-item">
                    <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>কাস্টম পেইজ সমূহ</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-concierge-bell"></i>
                        <p>সার্ভিস সমূহ</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.packages.index') }}" class="nav-link {{ request()->routeIs('admin.packages*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>প্যাকেজ / প্রাইসিং</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.portfolios.index') }}" class="nav-link {{ request()->routeIs('admin.portfolios*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>পোর্টফোলিও প্রজেক্ট</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.posts.index') }}" class="nav-link {{ request()->routeIs('admin.posts*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>ব্লগ পোস্ট সমূহ</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-quote-left"></i>
                        <p>প্রশংসাপত্র / রিভিউ</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.team.index') }}" class="nav-link {{ request()->routeIs('admin.team*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>টিম মেম্বারস</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.achievements.index') }}" class="nav-link {{ request()->routeIs('admin.achievements*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-trophy"></i>
                        <p>অর্জন ও কাউন্টার</p>
                    </a>
                </li>

                <li class="nav-header">গ্রাহক ও অনুসন্ধান</li>

                <li class="nav-item">
                    <a href="{{ route('admin.inquiries.index') }}" class="nav-link {{ request()->routeIs('admin.inquiries*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>
                            বার্তা ও কোটেশন
                            @php
                                $unreadCount = \App\Models\Inquiry::where('is_read', false)->count();
                            @endphp
                            @if ($unreadCount > 0)
                                <span class="badge badge-warning right">{{ $unreadCount }}</span>
                            @endif
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.subscribers.index') }}" class="nav-link {{ request()->routeIs('admin.subscribers*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>নিউজলেটার গ্রাহক</p>
                    </a>
                </li>

                <li class="nav-header">কনফিগারেশন</li>

                <li class="nav-item">
                    <a href="{{ route('admin.settings.edit') }}" class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>ওয়েবসাইট সেটিংস</p>
                    </a>
                </li>

                <li class="nav-header">অন্যান্য</li>

                <li class="nav-item">
                    <a href="{{ route('home') }}" target="_blank" class="nav-link">
                        <i class="nav-icon fas fa-external-link-alt"></i>
                        <p>লাইভ সাইট দেখুন</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
