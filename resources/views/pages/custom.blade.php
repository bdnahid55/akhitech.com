@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($page->content), 160))
@section('meta_keywords', $page->meta_keywords ?: '')
@section('canonical_url', $page->canonical_url ?: route('page.show', $page->slug))
@section('og_image', $page->og_image ? (str_starts_with($page->og_image, 'http') ? $page->og_image : asset($page->og_image)) : ($page->banner_image ? (str_starts_with($page->banner_image, 'http') ? $page->banner_image : asset($page->banner_image)) : ''))

@section('content')
    @include('layouts.partials.breadcrumb', ['title' => $page->title, 'subtitle' => $page->parent ? $page->parent->title : 'পেজ'])

    <section class="custom-page-content pt_100 pb_100 xs_pt_60 xs_pb_60">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <article class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white">
                        @if($page->banner_image)
                            <div class="mb-4 text-center overflow-hidden rounded-3">
                                <img src="{{ str_starts_with($page->banner_image, 'http') ? $page->banner_image : asset($page->banner_image) }}" alt="{{ $page->title }}" class="img-fluid rounded-3" style="max-height: 420px; width: 100%; object-fit: cover;">
                            </div>
                        @endif

                        <header class="mb-4">
                            <h1 class="fw-bold text-dark">{{ $page->title }}</h1>
                        </header>

                        <div class="page-body-content text-muted lh-lg" style="font-size: 1.05rem;">
                            {!! $page->content !!}
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection
