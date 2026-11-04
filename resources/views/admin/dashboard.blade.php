@extends('admin.layouts.app')

@section('title', 'ড্যাশবোর্ড')
@section('page_title', 'এডমিন ড্যাশবোর্ড')

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['services'] }}</h3>
                    <p>মোট সার্ভিস</p>
                </div>
                <div class="icon">
                    <i class="fas fa-concierge-bell"></i>
                </div>
                <a href="{{ route('admin.services.index') }}" class="small-box-footer">সার্ভিস তালিকা <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $stats['packages'] }}</h3>
                    <p>প্রাইসিং প্যাকেজ</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tags"></i>
                </div>
                <a href="{{ route('admin.packages.index') }}" class="small-box-footer">প্যাকেজ তালিকা <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['portfolios'] }}</h3>
                    <p>পোর্টফোলিও প্রজেক্ট</p>
                </div>
                <div class="icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <a href="{{ route('admin.portfolios.index') }}" class="small-box-footer">প্রজেক্ট তালিকা <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['posts'] }}</h3>
                    <p>ব্লগ পোস্ট</p>
                </div>
                <div class="icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="small-box-footer">ব্লগ তালিকা <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['unread_inquiries'] }}</h3>
                    <p>নতুন বার্তা / কোটেশন</p>
                </div>
                <div class="icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <a href="{{ route('admin.inquiries.index') }}" class="small-box-footer">সকল বার্তা <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Inquiries Table -->
        <div class="col-lg-8">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header border-transparent d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-inbox mr-1"></i> সাম্প্রতিক বার্তা ও কোটেশন</h3>
                    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-primary">সকল বার্তা দেখুন</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ধরন</th>
                                    <th>নাম</th>
                                    <th>ইমেইল / মোবাইল</th>
                                    <th>বিষয়</th>
                                    <th>সময়</th>
                                    <th>স্ট্যাটাস</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentInquiries as $inquiry)
                                    <tr>
                                        <td>
                                            @if ($inquiry->type === 'quote')
                                                <span class="badge badge-info">কোটেশন</span>
                                            @else
                                                <span class="badge badge-secondary">যোগাযোগ</span>
                                            @endif
                                        </td>
                                        <td class="font-weight-bold">{{ $inquiry->name }}</td>
                                        <td>
                                            <div>{{ $inquiry->email }}</div>
                                            @if ($inquiry->phone)
                                                <small class="text-muted">{{ $inquiry->phone }}</small>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($inquiry->subject, 30) }}</td>
                                        <td><small class="text-muted">{{ $inquiry->created_at->diffForHumans() }}</small></td>
                                        <td>
                                            @if ($inquiry->is_read)
                                                <span class="badge badge-success">পঠিত</span>
                                            @else
                                                <span class="badge badge-warning">নতুন</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">কোনো নতুন বার্তা বা কোটেশন নেই।</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Summary & Actions -->
        <div class="col-lg-4">
            <div class="card card-outline card-secondary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-bolt mr-1"></i> কুইক অ্যাকশন</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.services.create') }}" class="btn btn-outline-primary btn-block text-left mb-2">
                        <i class="fas fa-plus-circle mr-2"></i> নতুন সার্ভিস যুক্ত করুন
                    </a>
                    <a href="{{ route('admin.portfolios.create') }}" class="btn btn-outline-success btn-block text-left mb-2">
                        <i class="fas fa-plus-circle mr-2"></i> নতুন পোর্টফোলিও যুক্ত করুন
                    </a>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-warning btn-block text-left mb-2">
                        <i class="fas fa-plus-circle mr-2"></i> নতুন ব্লগ পোস্ট লিখুন
                    </a>
                    <a href="{{ route('admin.subscribers.index') }}" class="btn btn-outline-info btn-block text-left">
                        <i class="fas fa-envelope-open mr-2"></i> মোট সাবস্ক্রাইবার ({{ $stats['subscribers'] }})
                    </a>
                </div>
            </div>

            <div class="card card-outline card-dark shadow-sm">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-newspaper mr-1"></i> সাম্প্রতিক ব্লগ</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @forelse ($recentPosts as $post)
                            <li class="item">
                                <div class="product-info ml-2">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="product-title font-weight-bold">
                                        {{ Str::limit($post->title, 40) }}
                                    </a>
                                    <span class="product-description text-muted">
                                        {{ $post->published_at ? $post->published_at->format('d M, Y') : 'খসড়া' }} • {{ $post->author }}
                                    </span>
                                </div>
                            </li>
                        @empty
                            <li class="p-3 text-muted text-center">কোনো ব্লগ পাওয়া যায়নি।</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
