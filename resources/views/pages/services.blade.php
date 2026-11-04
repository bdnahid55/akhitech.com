@extends('layouts.app')

@section('title', 'আমাদের সার্ভিস সমূহ')

@section('content')
    @include('layouts.partials.breadcrumb', ['title' => 'আমাদের সার্ভিস সমূহ', 'subtitle' => 'সার্ভিস'])

    <!--==============================
        SERVICES PAGE START (DYNAMIC)
    ===============================-->
    <section class="services_page pt_120 xs_pt_80 pb_120 xs_pb_80">
        <div class="container">
            <div class="row">
                @forelse ($services as $service)
                    <div class="col-xl-3 col-md-6 col-lg-4 wow fadeInUp mb-4" data-wow-duration="1s">
                        <div class="service_item h-100 d-flex flex-column justify-content-between">
                            <div>
                                <span class="icon"><i class="{{ $service->icon ?: 'fas fa-laptop-code' }}"></i></span>
                                <h2>{{ $service->title }}</h2>
                                <p>{{ $service->short_description }}</p>
                                @if ($service->starting_price)
                                    <div class="badge bg-primary text-white py-2 px-3 mt-2 mb-3">
                                        শুরু ৳{{ number_format($service->starting_price) }} থেকে
                                    </div>
                                @endif
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('quote') }}" class="common_btn btn-sm">অর্ডার / কোটেশন</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fs-5">বর্তমানে কোনো সার্ভিস পাওয়া যায়নি।</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!--==============================
        SERVICES PAGE END
    ===============================-->
@endsection
