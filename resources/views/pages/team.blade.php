@extends('layouts.app')

@section('title', 'আমাদের অভিজ্ঞ টিম')

@section('content')
    @include('layouts.partials.breadcrumb', ['title' => 'আমাদের টিম', 'subtitle' => 'টিম মেম্বার'])

    <!--==============================
        TEAM PAGE START
    ===============================-->
    <section class="team_page pt_95 xs_pt_55 pb_120 xs_pb_80">
        <div class="container">
            <div class="row">
                @forelse ($teamMembers as $member)
                    <div class="col-xl-3 col-sm-6 col-lg-4 wow fadeInUp mb-4" data-wow-duration="1s">
                        <div class="single_team">
                            <img src="{{ $member->image ? asset($member->image) : asset('assets/front/img/team/17384272841396583989.png') }}" alt="{{ $member->name }}" class="img-fluid w-100">
                            <div class="text">
                                <a href="javascript:void(0)">{{ $member->name }}</a>
                                <p>{{ $member->designation }}</p>
                            </div>
                            <ul>
                                @if ($member->facebook)
                                    <li><a href="{{ $member->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                @endif
                                @if ($member->twitter)
                                    <li><a href="{{ $member->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                @endif
                                @if ($member->behance)
                                    <li><a href="{{ $member->behance }}" target="_blank"><i class="fab fa-behance"></i></a></li>
                                @endif
                                @if ($member->linkedin)
                                    <li><a href="{{ $member->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fs-5">বর্তমানে কোনো টিম মেম্বার পাওয়া যায়নি।</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!--==============================
        TEAM PAGE END
    ===============================-->
@endsection
