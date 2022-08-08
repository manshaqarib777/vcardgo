<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    @if(checkFeature('seo'))
        @if($vcard->meta_description)
            <meta name="description" content="{{$vcard->meta_description}}">
        @endif
        @if($vcard->meta_keyword)
            <meta name="keywords" content="{{$vcard->meta_keyword}}">
        @endif
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(checkFeature('seo') && $vcard->site_title && $vcard->home_title)
        <title>{{ $vcard->home_title }} | {{ $vcard->site_title }}</title>
    @else
        <title>{{ $vcard->name }} | {{ getAppName() }}</title>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">

    <title>{{ $vcard->name }} | {{ getAppName() }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ getFaviconUrl() }}" type="image/png">

    {{--css link--}}
    <link rel="stylesheet" href="{{ asset('assets/css/vcard5.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-vcard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">


    {{--google font--}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@500&family=PT+Sans:wght@700&family=Poppins:wght@600&family=Roboto&display=swap" rel="stylesheet">
    @if(checkFeature('custom_fonts') && $vcard->font_family)
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family={{$vcard->font_family}}">
    @endif

    @if($vcard->font_family || $vcard->font_size || $vcard->custom_css)
        <style>
            @if(checkFeature('custom_fonts'))
                @if($vcard->font_family)
                    body {
                        font-family: {{$vcard->font_family}};
                    }
                @endif
                @if($vcard->font_size)
                    div > h4 {
                font-size: {{$vcard->font_size}}px !important;
            }
            @endif
            @endif
            @if(isset(checkFeature('advanced')->custom_css))
                {!! $vcard->custom_css !!}
            @endif
        </style>
    @endif
</head>
<body>
<div class="container main-section">
    @include('vcards.password')
    <div class="row d-flex justify-content-center content-blur">
        <div class="main-bg p-0 collapse show allSection">
        @php

            $urlAlias = Route::current()->parameters['alias'];
            $vcard = App\Models\Vcard::whereUrlAlias($urlAlias)->first();
            if ($vcard) {
                $currentPlan = $vcard->subscriptions()->get()->where('status', 1)->first();
            }

            $startsAt = \Carbon\Carbon::now();
            $totalDays = \Carbon\Carbon::parse($currentPlan->starts_at)->diffInDays($currentPlan->trial_ends_at);
            $usedDays = \Carbon\Carbon::parse($currentPlan->starts_at)->diffInDays($startsAt);
            $remainingDays = $totalDays - $usedDays;
            $status = "";
            if($remainingDays > 0)
            {
                $status = "trail";
            }
            else if(\Carbon\Carbon::now() < $currentPlan->ends_at)
            {
                $status = "active";
            }
            else
            {
                $status = "expired";
            }
            @endphp
        <h2>{{ $currentPlan->plan->name }}</h2>
        <h5 class="mb-12">
            @if( \Carbon\Carbon::now() > $currentPlan->ends_at)
                <span class="text-danger">
                {{ __('messages.subscription.expired').' '.\Carbon\Carbon::parse($currentPlan->ends_at)->format('dS M, Y') }}
            </span>
            @else
                <span class="text-success">
                    {{ __('messages.subscription.active_until').' '.\Carbon\Carbon::parse($currentPlan->ends_at)->format('dS M, Y') }}
            </span>
            @endif
        </h5>
            <div class="head-img position-relative">
                <img src="{{ $vcard->cover_url }}" height="400px" class="img-fluid"/>
                <div class="d-flex justify-content-end position-absolute top-0 end-0 me-3">
                    @if($vcard->language_enable == \App\Models\Vcard::LANGUAGE_ENABLE)
                        <div class="language pt-4 me-2">
                            <ul class="text-decoration-none">
                                <li class="dropdown1 dropdown lang-list">
                                    <a class="dropdown-toggle lang-head text-decoration-none" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="fa-solid fa-language me-2"></i>{{getLanguage($vcard->default_language)}}
                                    </a>
                                    <ul class="dropdown-menu start-0 lang-hover-list top-dropdown top-100">
                                        @foreach(getAllLanguage() as $key => $language)
                                            <li class="{{ getLanguageIsoCode($vcard->default_language) === $key ? 'active' : '' }}">
                                                <a href="javascript:void(0)" id="languageName"
                                                   data-name="{{ $key }}">{{ $language }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
            <div class="profile-img">
                <img src="{{ $vcard->profile_url }}" width="150px"
                     class="pro-img me-sm-4 rounded-circle mb-4"/>
                <div>
                    <h4 class="big-title">{{ ucwords($vcard->first_name.' '.$vcard->last_name) }}</h4>
                    <p class="small-title">{{ ucwords($vcard->occupation) }}</p>
                </div>
            </div>
            {{--social-icon--}}
            <div class="container">
                @if(checkFeature('social_links') && getSocialLink($vcard))
                    <div class="social-section pb-4 px-sm-5">
                        <div class="social-icon">
                            @foreach(getSocialLink($vcard) as $value)
                                {!! $value !!}
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{--about-section--}}
            <div class="container">
                <div class="about-section mb-4">
                    <div class="row">
                        @if($vcard->email)
                            <div class="col-sm-6 pb-4">
                                <div class="about-details">
                                    <img src="{{asset('assets/img/aboutemail.png')}}" class="mb-2"/>
                                    <p><a href="mailto:{{ $vcard->email }}"
                                          class="about-title mb-0 text-decoration-none">{{ $vcard->email }}</a></p>
                                </div>
                            </div>
                        @endif
                        @if($vcard->dob)
                            <div class="col-sm-6 pb-4">
                                <div class="about-details">
                                    <img src="{{asset('assets/img/aboutcake.png')}}" class="mb-2"/>
                                    <p class="about-title mb-0">{{ \Carbon\Carbon::parse($vcard->dob)->format('dS F, Y') }}</p>
                                </div>
                            </div>
                        @endif
                        @if($vcard->phone)
                            <div class="col-sm-6 pb-4">
                                <div class="about-details">
                                    <img src="{{asset('assets/img/aboutcall.png')}}" class="mb-2"/>
                                    <p><a href="tel:{{ $vcard->phone }}"
                                          class="about-title mb-0 text-decoration-none">+{{ $vcard->region_code }} {{ $vcard->phone }}</a>
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if($vcard->location)
                            <div class="col-sm-6 pb-4">
                                <div class="about-details">
                                    <img src="{{asset('assets/img/aboutlocation.png')}}" class="mb-2"/>
                                    <p class="about-title mb-0">{!! $vcard->location !!}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{--Our service--}}
            @if(checkFeature('services') && $vcard->services->count())
                <div class="container">
                    <div class="main-our-service mb-4">
                        <div class="service-header-title">
                            <h4 class="mb-4">{{ __('messages.vcard.our_service') }}</h4>
                        </div>
                        <div class="row">
                            @foreach($vcard->services as $service)
                                <div class="col-12 mb-4">
                                    <div class="service-info d-flex align-items-center">
                                        <div class="service-img me-3 rounded-circle">
                                            <img src="{{ $service->service_icon }}" class="rounded-circle"/>
                                        </div>
                                        <div>
                                            <span class="service-heading">{{ ucwords($service->name) }}</span>
                                            <p class="mb-0 service-title">{!! $service->description !!}  </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            {{--gallery--}}
            @if(checkFeature('gallery') && $vcard->gallery->count())
            <div class="container">
                <div class="main-gallery pb-4">
                    <div class="gallery-header-title">
                        <h4 class="mb-4">{{ __('messages.plan.gallery') }}</h4>
                    </div>
                    <div class="row gallery-vcard d-flex justify-content-center g-3">
                        @foreach($vcard->gallery as $file)
                        <div class="col-6">
                            <div class="card gallery-shadow w-100">
                                <div class="gallery-profile">

                                        @if($file->link == null)
                                            <img src="{{$file->gallery_image}}" alt="profile" class="w-100"/>
                                        @else
                                            <div>
                                                <a id="video_url" data-id="https://www.youtube.com/embed/{{YoutubeID($file->link)}}" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                   class="gallery-link">
                                                    <div class="gallery-item"
                                                         style="background-image: url(&quot;https://vcard.waptechy.com/assets/img/video-thumbnail.png&quot;)">
                                                    </div>
                                                </a>
                                            </div>
                                        @endif

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <iframe id="video" src="//www.youtube.com/embed/Q1NKMPhP8PY"
                                        class="w-100" height="315">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{--Product--}}
            @if(checkFeature('products') && $vcard->products->count())
                <div class="container">
                    <div class="main-product pb-4">
                        <div class="product-header-title">
                            <h4 class="mb-4">{{ __('messages.plan.products') }}</h4>
                        </div>
                        <div class="row product-vcard d-flex justify-content-center g-3">
                            @foreach($vcard->products as $product)
                                <div class="col-6">
                                    <div class="card product-shadow w-100">
                                        <div class="product-profile">
                                            <img src="{{ $product->product_icon }}" alt="profile" class="w-100"
                                                 height="208px"/>
                                        </div>
                                        <div class="product-details mt-3">
                                            <h4>{{$product->name}}</h4>
                                            <p class="mb-2">
                                                {{$product->description}}
                                            </p>
                                            @if($product->currency_id && $product->price)
                                                <span
                                                    class="text-black">{{$product->currency->currency_icon}}{{$product->price}}</span>
                                            @elseif($product->price)
                                        <span class="text-black">{{$product->price}}</span>
                                    @else
                                        <span class="text-black">N/A</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{--testimonial--}}
            @if(checkFeature('testimonials') && $vcard->testimonials->count())
                <div class="container">
                    <div class="main-testimonial pb-4">
                        <div class="testimonial-header-title">
                            <h4 class="mb-4">{{ __('messages.plan.testimonials') }}</h4>
                        </div>
                        <div class="row testimonial-vcard d-flex justify-content-center g-3">
                            @foreach($vcard->testimonials as $testimonial)
                                <div class="col-12">
                                    <div class="card text-center testi-shadow w-100">
                                        <div>
                                            <p class="mb-3 testi-description">“{!! $testimonial->description !!}”</p>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="row d-flex justify-content-between align-items-end">
                                                <div class="col-lg-6">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $testimonial->image_url }}"
                                                             class="me-3 testi-logo rounded-circle"/>
                                                        <div>
                                                            <h6 class="testi-card-title mb-0">{{ ucwords($testimonial->name) }}</h6>
                                                            <p class="mb-0 testi-card-text"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            {{-- blog--}}
            @if(checkFeature('blog') && $vcard->blogs->count())
                <div class="container py-3 blog-section">
                    <h4 class="mb-4 blog-heading">{{ __('messages.feature.blog') }}</h4>
                    <div class="container px-0">
                        <div class="row g-4 blog-slider overflow-hidden">
                            @foreach($vcard->blogs as $blog)
                                <div class="col-6 mb-2">
                                    <div class="card blog-card border-0 w-100 h-100">
                                        <div class="blog-image">
                                            <a href="{{route('vcard.show-blog',[$vcard->url_alias,$blog->id])}}">
                                                <img src="{{ $blog->blog_icon }}" alt="profile" class="w-100"/>
                                            </a>
                                        </div>
                                        <div class="blog-details mt-3">
                                            <a href="{{route('vcard.show-blog',[$vcard->url_alias,$blog->id])}}" class="text-decoration-none">
                                                <h4 class="text-sm-start text-center title-color text-black p-3 mb-0">{{ $blog->title }}</h4>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            {{--Qr code--}}
            <div class="main-Qr-section mb-5">
                <div class="qr-header-title">
                    <h4 class="mb-5 text-center">{{ __('messages.vcard.qr_code') }}</h4>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="text-center mb-4">
                            {!! QrCode::size(130)->format('svg')->generate(Request::url()); !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <img src="{{$vcard->profile_url}}" width="125px"
                                 class="qr-logo rounded-circle"/>
                            <div class="mt-4">
                                <a class="btn btn-lg Qr-btn" id="qr-code-btn"
                                   download="qr_code.png">{{ __('messages.vcard.download_my_qr_code') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--business-hour--}}
            @if($vcard->businessHours->count())
                <div class="container">
                    <div class="main-business mb-4">
                        <div class="business-heading">
                            <h4 class="mb-4">{{ __('messages.business.business_hours') }}</h4>
                        </div>
                        <div class="row d-flex justify-content-center align-items-center">
                            @foreach($vcard->businessHours as $day)
                                <div class="col-lg-6 mb-3">
                                    <div class="card business-days flex-row justify-content-center">
                                <span class="me-2 business-title">
                                    {{ strtoupper(__('messages.business.'.\App\Models\BusinessHour::DAY_OF_WEEK[$day->day_of_week])).':' }}
                                </span>
                                        <span class="business-title">{{ $day->start_time.' - '.$day->end_time }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- registration custom idea --}}
        @if(checkFeature('registration_custom_idea'))
            <div class="vcard-one__timing py-3 px-1">
                <h4 class="vcard-one-heading text-center pb-4">{{ __('messages.vcard.registration_custom_idea') }}</h4>
                <div class="container pb-4">
                    <div class="row g-3">
                        @if($vcard->registration_address)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_address')).':' }}
                            </span>
                                <span>{{ $vcard->registration_address }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->registration_chassis_no)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_chassis_no')).':' }}
                            </span>
                                <span>{{ $vcard->registration_chassis_no }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->registration_vin_no)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_vin_no')).':' }}
                            </span>
                                <span>{{ $vcard->registration_vin_no }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->registration_vehicle_model)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_vehicle_model')).':' }}
                            </span>
                                <span>{{ $vcard->registration_vehicle_model }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->registration_vehicle_color)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_vehicle_color')).':' }}
                            </span>
                                <span>{{ $vcard->registration_vehicle_color }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->registration_vehicle_year)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_vehicle_year')).':' }}
                            </span>
                                <span>{{ $vcard->registration_vehicle_year }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->registration_plate_no)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_plate_no')).':' }}
                            </span>
                                <span>{{ $vcard->registration_plate_no }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->registration_country)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_country')).':' }}
                            </span>
                                <span>{{ $vcard->registration_country }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->registration_city)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_city')).':' }}
                            </span>
                                <span>{{ $vcard->registration_city }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->registration_district)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_district')).':' }}
                            </span>
                                <span>{{ $vcard->registration_district }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->registration_emergency_contact_no)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_emergency_contact_no')).':' }}
                            </span>
                                <span>{{ $vcard->registration_emergency_contact_no }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->registration_ar_no)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_ar_no')).':' }}
                            </span>
                                <span>{{ $vcard->registration_ar_no }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->registration_pcn_no)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_pcn_no')).':' }}
                            </span>
                                <span>{{ $vcard->registration_pcn_no }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        {{-- inspection custom idea --}}
        @if(checkFeature('inspection_custom_idea'))
            <div class="vcard-one__timing py-3 px-1">
                <h4 class="vcard-one-heading text-center pb-4">{{ __('messages.vcard.inspection_custom_idea') }}</h4>
                <div class="container pb-4">
                    <div class="row g-3">
                        @if($vcard->inspection_address)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_address')).':' }}
                            </span>
                                <span>{{ $vcard->inspection_address }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->inspection_chassis_no)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_chassis_no')).':' }}
                            </span>
                                <span>{{ $vcard->inspection_chassis_no }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->inspection_vin_no)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_vin_no')).':' }}
                            </span>
                                <span>{{ $vcard->inspection_vin_no }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->inspection_vehicle_model)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_vehicle_model')).':' }}
                            </span>
                                <span>{{ $vcard->inspection_vehicle_model }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->inspection_vehicle_color)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_vehicle_color')).':' }}
                            </span>
                                <span>{{ $vcard->inspection_vehicle_color }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->inspection_vehicle_year)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_vehicle_year')).':' }}
                            </span>
                                <span>{{ $vcard->inspection_vehicle_year }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->inspection_plate_no)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_plate_no')).':' }}
                            </span>
                                <span>{{ $vcard->inspection_plate_no }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->inspection_contact)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_contact')).':' }}
                            </span>
                                <span>{{ $vcard->inspection_contact }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->inspection_ar_no)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_ar_no')).':' }}
                            </span>
                                <span>{{ $vcard->inspection_ar_no }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->inspection_country)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_country')).':' }}
                            </span>
                                <span>{{ $vcard->inspection_country }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->inspection_city)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_city')).':' }}
                            </span>
                                <span>{{ $vcard->inspection_city }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->inspection_district)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_district')).':' }}
                            </span>
                                <span>{{ $vcard->inspection_district }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->inspection_control_technique)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_control_technique')).':' }}
                            </span>
                                <span class="{{$status =='trail' ? 'text-warning':($status =='active' ? 'text-success':'text-danger') }}">{{ $vcard->inspection_control_technique }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->inspection_date_of_inspection)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_date_of_inspection')).':' }}
                            </span>
                                <span>{{ $vcard->inspection_date_of_inspection }}</span>
                            </div>
                        </div>
                        @endif
                        @if($status)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_date_of_expiration')).':' }}
                            </span>
                                <span class="{{$status =='trail' ? 'text-warning':($status =='active' ? 'text-success':'text-danger') }}">{{ \Carbon\Carbon::parse($currentPlan->ends_at)->format('dS M, Y') }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- parking custom idea --}}
        @if(checkFeature('parking_custom_idea'))
            <div class="vcard-one__timing py-3 px-1">
                <h4 class="vcard-one-heading text-center pb-4">{{ __('messages.vcard.parking_custom_idea') }}</h4>
                <div class="container pb-4">
                    <div class="row g-3">

                        @if($vcard->parking_owner_mobile_no)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_owner_mobile_no')).':' }}
                            </span>
                                <span>{{ $vcard->parking_owner_mobile_no }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->parking_address)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_address')).':' }}
                            </span>
                                <span>{{ $vcard->parking_address }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->parking_vehicle_color)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_vehicle_color')).':' }}
                            </span>
                                <span>{{ $vcard->parking_vehicle_color }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->parking_vehicle_model)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_vehicle_model')).':' }}
                            </span>
                                <span>{{ $vcard->parking_vehicle_model }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->parking_plate_no)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_plate_no')).':' }}
                            </span>
                                <span>{{ $vcard->parking_plate_no }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->parking_mobile)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_mobile')).':' }}
                            </span>
                                <span>{{ $vcard->parking_mobile }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->parking_country)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_country')).':' }}
                            </span>
                                <span>{{ $vcard->parking_country }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->parking_city)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_city')).':' }}
                            </span>
                                <span>{{ $vcard->parking_city }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->parking_district)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_district')).':' }}
                            </span>
                                <span>{{ $vcard->parking_district }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->parking_p_place_of_registration)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_p_place_of_registration')).':' }}
                            </span>
                                <span>{{ $vcard->parking_p_place_of_registration }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->parking_p_registration_officer)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_p_registration_officer')).':' }}
                            </span>
                                <span>{{ $vcard->parking_p_registration_officer }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->parking_p_date_of_payment)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_p_date_of_payment')).':' }}
                            </span>
                                <span>{{ $vcard->parking_p_date_of_payment }}</span>
                            </div>
                        </div>
                        @endif
                        @if($status)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_expiration_date')).':' }}
                            </span>
                                <span class="{{$status =='trail' ? 'text-warning':($status =='active' ? 'text-success':'text-danger') }}">{{ \Carbon\Carbon::parse($currentPlan->ends_at)->format('dS M, Y') }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->parking_parking_plan)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_parking_plan')).':' }}
                            </span>
                                <span>{{ $vcard->parking_parking_plan }}</span>
                            </div>
                        </div>
                        @endif

                        @if($status)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_status')).':' }}
                            </span>
                                <span class="{{$status =='trail' ? 'text-warning':($status =='active' ? 'text-success':'text-danger') }}">{{ strtoupper($status) }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->parking_date_of_inspection)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_date_of_inspection')).':' }}
                            </span>
                                <span>{{ $vcard->parking_date_of_inspection }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
            {{--Appointment--}}
            @if(checkFeature('appointments') && $vcard->appointmentHours->count())
                <div class="container py-3 mb-4 appointment-section">
                    <h4 class="appointment-heading mb-4 position-relative">{{__('messages.make_appointments')}}</h4>
                    <div class="appointment">
                        <div class="row d-flex align-items-center justify-content-center mb-3">
                            <div class="col-md-2">
                                <label for="date" class="appoint-date mb-2">{{__('messages.date')}}</label>
                            </div>
                            <div class="col-md-10">
                                {{ Form::text('date', null, ['class' => 'date appoint-input', 'placeholder' => 'Pick a Date','id'=>'pickUpDate']) }}
                            </div>
                        </div>
                        <div class="row d-flex align-items-center justify-content-center mb-md-3">
                            <div class="col-md-2">
                                <label for="text" class="appoint-date mb-2">{{__('messages.hour')}}</label>
                            </div>
                            <div class="col-md-10">
                                <div id="slotData" class="row">
                                </div>
                            </div>
                        </div>

                        <button type="button"
                                class="appointmentAdd appoint-btn text-white mt-4 d-block mx-auto ">{{__('messages.make_appointments')}}
                        </button>
                        @include('vcardTemplates.appointment')
                    </div>
                </div>
            @endif

            {{--contact us--}}
            @php $currentSubs = $vcard->subscriptions()->where('status', \App\Models\Subscription::ACTIVE)->latest()->first() @endphp
            @if($currentSubs && $currentSubs->plan->planFeature->enquiry_form)
                <div class="container py-4">
                    <h4 class="contact-heading mb-4 text-center">{{ __('messages.contact_us.contact_us') }}</h4>
                    <div class="main-contact">
                        <form id="enquiryForm">
                            @csrf
                            <div class="row">
                                <div id="enquiryError" class="alert alert-danger d-none"></div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <label for="basic-url"
                                               class="form-label mb-0">{{ __('messages.user.your_name') }}</label>
                                        <div class="col-12 mb-3 input-group">
                                    <span class="input-group-text bg-white contact-input border-end-0"
                                          id="basic-addon1"><i
                                                class="far fa-user"></i></span>
                                            <input type="text" name="name"
                                                   class="form-control contact-input border-start-0"
                                                   id="name" placeholder="{{__('messages.form.your_name')}}">
                                        </div>

                                        <label for="basic-url"
                                               class="form-label mb-0">{{ __('messages.user.email') }}</label>
                                        <div class="col-12 mb-3 input-group">
                                    <span class="input-group-text bg-white contact-input border-end-0"
                                          id="basic-addon1"><i
                                                class="far fa-envelope"></i></span>
                                            <input type="email" name="email"
                                                   class="form-control contact-input border-start-0"
                                                   id="email" placeholder="{{__('messages.form.your_email')}}">
                                        </div>

                                        <label for="inputAddress"
                                               class="form-label mb-0">{{ __('messages.user.phone') }}</label>
                                        <div class="col-12 mb-3 input-group">
                                    <span class="input-group-text bg-white contact-input border-end-0"
                                          id="basic-addon1"><i
                                                class="fas fa-phone"></i></span>
                                            <input type="tel" name="phone"
                                                   class="form-control contact-input border-start-0"
                                                   id="phone" placeholder="{{__('messages.form.phone')}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="exampleFormControlTextarea1"
                                                   class="form-label">{{ __('messages.user.your_message') }}</label>
                                            <textarea class="form-control contact-input" name="message" id="message"
                                                      rows="7"
                                                      placeholder="{{__('messages.form.type_message')}}"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-3">
                                    <button type="submit"
                                            class="btn contact-btn px-4">{{ __('messages.contact_us.send_message') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            <div class="d-sm-flex justify-content-center mt-5">
                <button type="submit" class="vcard-five-btn mt-4 btn d-block btn text-white"
                        onclick="downloadVcard('{{ $vcard->name }}.vcf',{{ $vcard->id }})"><i
                            class="fas fa-download me-2"></i>{{ __('messages.vcard.download_vcard') }}
                </button>
                {{--share btn--}}
                <button type="button" class="vcard5-share share-btn text-white d-block btn mt-4 ms-sm-3">
                    <a class="text-white text-decoration-none">
                        <i class="fas fa-share-alt me-2"></i>{{ __('messages.vcard.share') }}</a>
                </button>
            </div>
            @if($vcard->location_url && isset($url[5]))
                <div class="m-2 ">
                    <iframe width="100%" height="300px" src='https://maps.google.de/maps?q={{$url[5]}}/&output=embed'
                            frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                            style="border-radius: 10px;"></iframe>
                </div>
            @endif
            <div class="d-flex justify-content-evenly">
                @if(!isset(checkFeature('advanced')->hide_branding) || $vcard->branding == 0)
                    <div class="text-center">
                        <small>Made By {{ $setting['app_name'] }}</small>
                    </div>
                @endif
                @if(!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                    <div>
                        <a class="text-decoration-none text-dark cursor-pointer terms-policies-btn"><small>{{__('messages.vcard.term_policy')}}</small></a>
                    </div>
                @endif
            </div>
        </div>
        <div class="main-bg vcard-five__contact py-5 collapse terms-policies-section">
            @if(!empty($vcard->privacy_policy))
                <div class="container">
                    <h4 class="contact-heading text-center py-4 heading-title">{{ __('messages.vcard.privacy_policy') }}</h4>
                    <div class="card px-sm-3 px-4 py-md-5 py-4 m-3">
                        <div class="px-3 ">
                            {!! $vcard->privacy_policy->privacy_policy !!}
                        </div>
                    </div>
                </div>
            @endif
            <hr>
            @if(!empty($vcard->term_condition))
                <div class="container">
                    <h4 class="contact-heading text-center py-4 heading-title">{{ __('messages.vcard.term_condition') }}</h4>
                    <div class="card px-sm-3 px-4 py-md-5 py-4 m-3">
                        <div class="px-3 ">
                            {!! $vcard->term_condition->term_condition !!}
                        </div>
                    </div>
                </div>
            @endif
            <div class="text-center mt-3">
                <button class="btn vcard-five-btn text-white px-4 cursor-pointer terms-policies-btn">{{ __('messages.common.back') }}</button>
            </div>
        </div>
    </div>
    {{-- share modal code--}}
    <div id="vcard5-shareModel" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.vcard.share_my_vcard') }}</h5>
                    <button type="button" aria-label="Close" class="btn btn-sm btn-icon btn-active-color-danger"
                            data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
						<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                             version="1.1">
							<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                               fill="#000000">
								<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"/>
								<rect fill="#000000" opacity="0.5"
                                      transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                      x="0" y="7" width="16" height="2" rx="1"/>
							</g>
						</svg>
					</span>
                    </button>
                </div>
                @php
                    $shareUrl = route('vcard.defaultIndex')."/".$vcard->url_alias;
                @endphp
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 justify-content-between social-link-modal">
                            <a href="http://www.facebook.com/sharer.php?u={{$shareUrl}}"
                               target="_blank" class="mx-2 share5" title="Facebook">
                                <i class="fab fa-facebook fa-3x" style="color: #1B95E0"></i>
                            </a>
                            <a href="http://twitter.com/share?url={{$shareUrl}}&text={{$vcard->name}}&hashtags=sharebuttons"
                               target="_blank" class="mx-2 share5" title="Twitter">
                                <i class="fab fa-twitter fa-3x" style="color: #1DA1F3"></i>
                            </a>
                            <a href="http://www.linkedin.com/shareArticle?mini=true&url={{$shareUrl}}"
                               target="_blank" class="mx-2 share5" title="Linkedin">
                                <i class="fab fa-linkedin fa-3x" style="color: #1B95E0"></i>
                            </a>
                            <a href="mailto:?Subject=&Body={{$shareUrl}}" target="_blank"
                               class="mx-2 share5" title="Email">
                                <i class="fas fa-envelope fa-3x" style="color: #191a19  "></i>
                            </a>
                            <a href="http://pinterest.com/pin/create/link/?url={{$shareUrl}}"
                               target="_blank" class="mx-2 share5" title="Pinterest">
                                <i class="fab fa-pinterest fa-3x" style="color: #bd081c"></i>
                            </a>
                            <a href="http://reddit.com/submit?url={{$shareUrl}}&title={{$vcard->name}}"
                               target="_blank" class="mx-2 share5" title="Reddit">
                                <i class="fab fa-reddit fa-3x" style="color: #ff4500"></i>
                            </a>
                            <a href="https://wa.me/?text={{$shareUrl}}" target="_blank" class="mx-2 share5" title="Whatsapp">
                                <i class="fab fa-whatsapp fa-3x" style="color: limegreen"></i>
                            </a>
                        </div>
                    </div>
                    <div class="text-center">

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@include('vcardTemplates.template.templates')
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript" src="{{ asset('assets/js/front-third-party.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/slider/js/slick.min.js') }}" type="text/javascript"></script>
@if(checkFeature('seo') && $vcard->google_analytics)
    {!! $vcard->google_analytics !!}
@endif
@if(isset(checkFeature('advanced')->custom_js) && $vcard->custom_js)
    {!! $vcard->custom_js !!}
@endif
@php
    $setting = \App\Models\UserSetting::where('user_id', $vcard->tenant->user->id)->where('key', 'stripe_key')->first();
@endphp
<script>
    let stripe = ''
    @if (!empty($setting) && !empty($setting->value))
        stripe = Stripe('{{ $setting->value }}');
    @endif
    $('.testimonial-vcard').slick({
        dots: true,
        infinite: true,
        speed: 300,
        autoplay: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
    });
</script>
<script>
    $('.product-vcard').slick({
        dots: true,
        infinite: true,
        arrows: false,
        speed: 300,
        slidesToShow: 2,
        autoplay: true,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 575,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            }
        ]
    });
</script>
<script>
    $('.gallery-vcard').slick({
        dots: true,
        infinite: true,
        arrows: false,
        speed: 300,
        slidesToShow: 2,
        autoplay: true,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 575,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true,
                },
            }
        ]
    });

    $('.blog-slider').slick({
        dots: true,
        infinite: true,
        arrows: false,
        speed: 300,
        slidesToShow: 1,
        autoplay: true,
        slidesToScroll: 1,
    })
</script>
<script>
    let isEdit = false
    let password = "{{isset(checkFeature('advanced')->password) && !empty($vcard->password) }}"
    let passwordUrl = "{{ route('vcard.password', $vcard->id) }}";
    let enquiryUrl = "{{ route('enquiry.store', $vcard->id) }}";
    let appointmentUrl = "{{ route('appointment.store', $vcard->id) }}";
    let paypalUrl = "{{ route('paypal.init') }}"
    let slotUrl = "{{route('appointment-session-time')}}";
    let appUrl = "{{ config('app.url') }}";
    let vcardId = {{$vcard->id}};
    let vcardAlias = "{{$vcard->url_alias}}";
    let languageChange = "{{ url('language') }}";
    let lang = "{{checkLanguageSession()}}";
</script>
<script>
    const svg = document.getElementsByTagName('svg')[0];
    const { x, y, width, height } = svg.viewBox.baseVal;
    const blob = new Blob([svg.outerHTML], { type: 'image/svg+xml' });
    const url = URL.createObjectURL(blob);
    const image = document.createElement('img');
    image.src = url;
    image.addEventListener('load', () => {
        const canvas = document.createElement('canvas');
        canvas.width = width;
        canvas.height = height;
        const context = canvas.getContext('2d');
        context.drawImage(image, x, y, width, height);
        const link = document.getElementById('qr-code-btn');
        link.href = canvas.toDataURL();
        URL.revokeObjectURL(url);
    });
</script>
@routes
<script src="{{ mix('assets/js/custom/helpers.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom.js') }}"></script>
<script src="{{ mix('assets/js/vcards/vcard-view.js') }}"></script>

</body>
</html>
