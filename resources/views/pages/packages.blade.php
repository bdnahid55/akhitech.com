@extends('layouts.app')

@section('title', 'আমাদের প্যাকেজ সমূহ | প্রাইসিং প্ল্যান')

@section('content')
    @include('layouts.partials.breadcrumb', ['title' => 'আমাদের প্যাকেজ সমূহ', 'subtitle' => 'প্যাকেজ সমূহ'])

    <!--==============================
        PRICING START (DYNAMIC)
    ===============================-->
    <section class="pricing pt_95 xs_pt_55 pb_120 xs_pb_80">
        <div class="container">
            <div class="row">
                @forelse ($packages as $package)
                    <div class="col-xl-4 col-md-6 wow fadeInUp mb-4" data-wow-duration="1s">
                        <div class="single_pricing {{ $package->is_featured ? 'active' : '' }}">
                            <h4>{{ $package->name }}</h4>
                            <h2>
                                {{ $package->currency }}{{ $package->price }}
                                @if ($package->period)
                                    <span>{{ str_starts_with($package->period, '/') ? $package->period : '/'.$package->period }}</span>
                                @endif
                            </h2>
                            @if (!empty($package->features) && is_array($package->features))
                                <ul>
                                    @foreach ($package->features as $feature)
                                        @php
                                            $featureTrimmed = trim((string) $feature);
                                            $isDelete = str_starts_with($featureTrimmed, 'x ') || str_starts_with($featureTrimmed, '[x]') || str_starts_with($featureTrimmed, '- ');
                                            $featureText = preg_replace('/^(x\s+|\[x\]\s*|-\s+)/', '', $featureTrimmed);
                                        @endphp
                                        <li class="{{ $isDelete ? 'delete' : '' }}">{{ $featureText }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <a href="{{ $package->button_url ?: route('quote', ['package' => $package->name]) }}">
                                {{ $package->button_text ?: 'আমি নিতে চাই' }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fs-5">বর্তমানে কোনো প্যাকেজ পাওয়া যায়নি।</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!--==============================
        PRICING END
    ===============================-->
@endsection
