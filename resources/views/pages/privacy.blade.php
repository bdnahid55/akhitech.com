@extends('layouts.app')

@section('title', 'প্রাইভেসি পলিসি')

@section('content')
    @include('layouts.partials.breadcrumb', ['title' => 'প্রাইভেসি পলিসি', 'subtitle' => 'পলিসি'])

    <section class="pt-120 pb-120 pt_120 pb_120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card p-4 p-md-5 border-0 shadow-sm rounded-3">
                        <h2 class="mb-4 text-primary">আমাদের প্রাইভেসি পলিসি</h2>
                        <p class="lead">
                            {{ $siteSettings['site_name'] ?? config('app.name', 'Akhitech') }}-এ আপনার ব্যক্তিগত তথ্যের গোপনীয়তা রক্ষা করা আমাদের অন্যতম প্রধান দায়িত্ব।
                        </p>
                        <h4 class="mt-4">১. তথ্য সংগ্রহ</h4>
                        <p>
                            যখন আপনি আমাদের ওয়েবসাইটে যোগাযোগ ফরম পূরণ করেন অথবা নিউজলেটারে সাবস্ক্রাইব করেন, তখন আমরা আপনার নাম, ইমেইল ঠিকানা ও ফোন নাম্বার সংগ্রহ করে থাকি।
                        </p>
                        <h4 class="mt-4">২. তথ্যের ব্যবহার</h4>
                        <p>
                            আপনার তথ্যসমূহ শুধুমাত্র আপনার সাথে যোগাযোগ করতে, প্রকল্প বা সেবার বিস্তারিত জানাতে এবং কাস্টমার সাপোর্ট প্রদান করতে ব্যবহৃত হয়। আমরা কখনোই আপনার তথ্য তৃতীয় কোনো পক্ষের কাছে বিক্রি বা হস্তান্তর করি না।
                        </p>
                        <h4 class="mt-4">৩. নিরাপত্তা</h4>
                        <p>
                            আপনার প্রেরিত তথ্য সম্পূর্ণ নিরাপদ ও সুরক্ষিত সার্ভারে এনক্রিপ্টেড অবস্থায় সংরক্ষিত থাকে।
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
