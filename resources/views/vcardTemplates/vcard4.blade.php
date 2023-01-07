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
    <link rel="stylesheet" href="{{ asset('assets/css/vcard4.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-vcard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">



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
<div class="container">
    @include('vcards.password')
    <div class="main-content vcard w-100 mx-auto content-blur collapse show allSection">
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
        <div class="vcard__banner w-100 position-relative">
            <img src="{{ $vcard->cover_url }}" class="img-fluid banner-image" alt="banner"/>
            <div class="d-flex justify-content-end position-absolute top-0 end-0 me-3">
                @if($vcard->language_enable == \App\Models\Vcard::LANGUAGE_ENABLE)
                    <div class="language pt-4 me-2">
                        <ul class="text-decoration-none">
                            <li class="dropdown1 dropdown lang-list">
                                <a class="dropdown-toggle lang-head text-decoration-none" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-language me-2"></i>{{ getLanguage($vcard->default_language)}}
                                </a>
                                <ul class="dropdown-menu  start-0 lang-hover-list top-dropdown top-100">
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
        {{--profile details--}}
        <div class="vcard__profile d-flex align-items-center px-4 flex-sm-row flex-column">
            <div class="vcard__avatar">
                <img src="{{ $vcard->profile_url }}" class="rounded-circle"/>
            </div>
            <div class="vcard__position d-flex flex-column mx-sm-4 mt-sm-5 mt-2">
                <div class="d-flex flex-column vcard_details">
                    <h4 class="avatar-name text-sm-start text-center">{{ ucwords($vcard->first_name.' '.$vcard->last_name) }}</h4>
                    <span class="avatar-designation text-sm-start text-center">{{ ucwords($vcard->occupation) }}</span>
                </div>
                @if(checkFeature('social_links') && getSocialLink($vcard))
                    <div class="social-icons d-flex flex-wrap justify-content-center pt-4 vcard__social">
                        @foreach(getSocialLink($vcard) as $value)
                            <span class="icons rounded-circle d-flex justify-content-center align-items-center">
                            {!! $value !!}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        {{--details--}}
        <div class="px-4 my-3">
            <div class="vcard__event">
                <div class="row py-4 g-3">
                    @if($vcard->email)
                        <div class="col-sm-6 col-12">
                            <div class="card vcard__event-card d-flex flex-column justify-content-center align-items-center border-0 p-3 h-100">
                            <span class="event-icon">
                                <img src="{{ asset('assets/img/vcard4/email.png') }}" class="img-fluid">
                            </span>
                                <a href="mailto:{{ $vcard->email }}"
                                   class="event-name text-center mb-0 pt-2 text-decoration-none">{{ $vcard->email }}</a>
                            </div>
                        </div>
                    @endif
                    @if($vcard->dob)
                        <div class="col-sm-6 col-12">
                            <div class="card vcard__event-card d-flex flex-column justify-content-center align-items-center border-0 p-3 h-100">
                            <span class="event-icon">
                                <img src="{{ asset('assets/img/vcard4/birthday.png') }}" class="img-fluid">
                            </span>
                                <span class="event-name pt-2">{{ \Carbon\Carbon::parse($vcard->dob)->format('dS F, Y') }}</span>
                            </div>
                        </div>
                    @endif
                    @if($vcard->phone)
                        <div class="col-sm-6 col-12">
                            <div class="card vcard__event-card d-flex flex-column justify-content-center align-items-center border-0 p-3 h-100">
                            <span class="event-icon">
                                <img src="{{ asset('assets/img/vcard4/mobile.png') }}" class="img-fluid">
                            </span>
                                <a href="tel:{{ $vcard->phone }}"
                                   class="event-name text-center mb-0 pt-2 text-decoration-none">+{{ $vcard->region_code }} {{ $vcard->phone }}</a>
                            </div>
                        </div>
                    @endif
                    @if($vcard->location)
                        <div class="col-sm-6 col-12">
                            <div class="card vcard__event-card d-flex flex-column justify-content-center align-items-center border-0 p-3 h-100">
                            <span class="event-icon">
                                <img src="{{ asset('assets/img/vcard4/location.png') }}" class="img-fluid">
                            </span>
                                <span class="event-name pt-2">{{$vcard->location}}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{--our services--}}
       @if(checkFeature('services') && $vcard->services->count())
            <div class="my-4 px-4 pb-2 position-relative overflow-hidden">
                <div class="line-shape position-absolute">
                    <span class="inner-circle position-absolute rounded-circle"></span>
                </div>
                <div class="vcard__service">
                    <h4 class="vcard__heading text-center pb-3">{{ __('messages.vcard.our_service') }}</h4>
                    <div class="container mt-4">
                        <div class="row g-4 justify-content-center">
                            @foreach($vcard->services as $service)
                                <div class="col-sm-6 service-container">
                                    <div class="card service-card h-100 border-0">
                                        <div
                                                class="service-image rounded-circle d-flex justify-content-center align-items-center mx-auto">
                                            <img src="{{ $service->service_icon }}" class="rounded-circle"/>
                                        </div>
                                        <div class="service-details d-flex flex-column">
                                            <h4 class="mt-3 text-center">{{ ucwords($service->name) }}</h4>
                                            <p class="mb-0 text-center">
                                                {!! $service->description !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{--gallery--}}
        @if(checkFeature('gallery') && $vcard->gallery->count())
        <div class="pt-4 px-4">
            <div class="vcard__gallery">
                <h4 class="vcard__heading text-center pb-2">{{ __('messages.plan.gallery') }}</h4>
                @foreach($vcard->gallery as $file)
                    @if($file->fine == "Suspended")
                        <img src="https://safety.idkaccounting.com/imgs/suspended.png" alt="profile" class="w-100"/>
                        @break
                    @endif
                @endforeach
                <div class="container mt-4 py-3">
                    <div class="row g-4 justify-content-center gallery-slider">
                        @foreach($vcard->gallery as $file)
                        <div class="col-6">
                            <div class="card gallery-card h-100 border-0 w-100">
                                <div class="gallery-profile">
                                    @if($file->link == null)
                                        <img src="{{$file->gallery_image}}" alt="profile" class="w-100"/>
                                    @else
                                        <a id="video_url" data-id="https://www.youtube.com/embed/{{YoutubeID($file->link)}}" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                           class="gallery-link">
                                            <div class="gallery-item"
                                                 style="background-image: url(&quot;https://vcard.waptechy.com/assets/img/video-thumbnail.png&quot;)">
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
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
            <div class="pt-4 px-4 position-relative">
                <div class="vcard__product">
                    <h4 class="vcard__heading text-center pb-2">{{ __('messages.plan.products') }}</h4>
                    <div class="container mt-4 py-3">
                        <div class="row g-4 justify-content-center product-slider">
                            @foreach($vcard->products as $product)
                                <div class="col-6">
                                    <div class="card product-card h-100 border-0 w-100">
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
        </div>
            @endif
        {{--Testimonial--}}
        @if(checkFeature('testimonials') && $vcard->testimonials->count())
            <div class="pt-4 px-4">
                <div class="vcard__testimonial">
                    <h4 class="vcard__heading text-center pb-2">{{ __('messages.plan.testimonials') }}</h4>
                    <div class="container mt-4 py-3">
                        <div class="row g-4 justify-content-center testimonial-slider">
                            @foreach($vcard->testimonials as $testimonial)
                                <div class="col-6">
                                    <div class="card testimonial-card h-100 border-0 w-100">
                                        <img src="{{ $testimonial->image_url }}"
                                             class="testimonial-image d-block mx-auto"/>
                                        <div class="testimonial-details d-flex flex-column">
                                            <p class="mb-0 text-center pt-3">
                                                {{ $testimonial->description }}
                                            </p>
                                        </div>
                                        <div class="testimonial-user d-flex justify-content-center flex-column align-center mt-3">
                                            <h5 class="user-name text-center position-relative mt-2">{{ ucwords($testimonial->name) }}</h5>
                                            <span class="user-designation text-center"></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- blog--}}
        @if(checkFeature('blog') && $vcard->blogs->count())
            <div class="vcard__blog py-3">
                <h4 class="vcard__heading heading-line position-relative text-center pb-4">{{ __('messages.feature.blog') }}</h4>
                <div class="container">
                    <div class="row g-4 blog-slider overflow-hidden">
                        @foreach($vcard->blogs as $blog)
                            <div class="col-6 mb-2">
                                <div class="card blog-card p-2 border-0 w-100 h-100">
                                    <div class="blog-image w-100">
                                        <a href="{{route('vcard.show-blog',[$vcard->url_alias,$blog->id])}}">
                                            <img src="{{ $blog->blog_icon }}" alt="profile" class="w-100"/>
                                        </a>
                                    </div>
                                    <div class="blog-details">
                                        <a href="{{route('vcard.show-blog',[$vcard->url_alias,$blog->id])}}" class="text-decoration-none">
                                            <h4 class="text-sm-start text-center title-color text-black p-3 mb-0">{{ $blog->title }}</h4></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        {{--Qr code--}}
        @if(checkFeature('qr_code'))
        <div class="vcard__qr-code">
            <div class="px-4 pt-5 pb-4">
                <h4 class="vcard__heading text-center pb-10">{{ __('messages.vcard.qr_code') }}</h4>
                <div class="qr-code d-block mx-auto position-relative px-5 pt-5 pb-3">
                    <img src="{{$vcard->profile_url}}"
                         class="qr-code-profile d-block mx-auto position-absolute top-0 start-50 translate-middle"/>
                    <div class="qr-code-image d-flex justify-content-center pt-7">
                        {!! QrCode::size(130)->format('svg')->generate(Request::url()); !!}
                    </div>
                </div>
                    <a class="qr-code-btn text-white mt-4 d-block mx-auto text-decoration-none" id="qr-code-btn"
                       download="qr_code.png">{{ __('messages.vcard.download_my_qr_code') }}</a>
            </div>
        </div>
        @endif
        {{--business hour--}}
        @if($vcard->businessHours->count() && checkFeature('business_hours'))

            <div class="vcard__timing pt-5 pb-4">
                <div class="px-4">
                    <h4 class="vcard__heading text-center pb-4">{{ __('messages.vcard.buisness_hours') }}</h4>
                    <div class="row">
                        @foreach($vcard->businessHours as $day)
                            <div class="col-sm-6 col-12 week-time mb-2 text-center">
                                <div class="card business-card flex-row justify-content-center">
                                    <span class="me-2">{{ strtoupper(__('messages.business.'.\App\Models\BusinessHour::DAY_OF_WEEK[$day->day_of_week]))}}:</span>
                                    <span>{{ $day->start_time.' - '.$day->end_time }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        {{-- registration custom idea --}}
        @if(checkFeature('registration_custom_idea') && $vcard->registration_address)
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
                                                @if($vcard->registrationCountry)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_country')).':' }}
                            </span>
                                <span>{{ $vcard->registrationCountry->name }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->registrationState)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_state')).':' }}
                            </span>
                                <span>{{ $vcard->registrationState->name }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->registrationCity)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.registration_city')).':' }}
                            </span>
                                <span>{{ $vcard->registrationCity->name }}</span>
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
        @if(checkFeature('inspection_custom_idea') && $vcard->inspection_address)
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
                        @if($vcard->inspectionCountry)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_country')).':' }}
                            </span>
                                <span>{{ $vcard->inspectionCountry->name }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->inspectionState)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_state')).':' }}
                            </span>
                                <span>{{ $vcard->inspectionState->name }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->inspectionCity)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.inspection_city')).':' }}
                            </span>
                                <span>{{ $vcard->inspectionCity->name }}</span>
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
        {{-- inspection custom idea new --}}
@if(checkFeature('inspection_custom_idea_new') && $vcard->inspection_address_new)
    <div class="vcard-one__timing py-3 px-1">
        <h4 class="vcard-one-heading text-center pb-4">{{ __('messages.vcard.inspection_custom_idea_new') }}</h4>
        <div class="container pb-4">
            <div class="row g-3">
                @if($vcard->inspection_address_new)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_address_new')).':' }}
                    </span>
                        <span>{{ $vcard->inspection_address_new }}</span>
                    </div>
                </div>
                @endif
                @if($vcard->inspection_chassis_no_new)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_chassis_no_new')).':' }}
                    </span>
                        <span>{{ $vcard->inspection_chassis_no_new }}</span>
                    </div>
                </div>
                @endif
                @if($vcard->inspection_vin_no_new)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_vin_no_new')).':' }}
                    </span>
                        <span>{{ $vcard->inspection_vin_no_new }}</span>
                    </div>
                </div>
                @endif
                @if($vcard->inspection_vehicle_model_new)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_vehicle_model_new')).':' }}
                    </span>
                        <span>{{ $vcard->inspection_vehicle_model_new }}</span>
                    </div>
                </div>
                @endif
                @if($vcard->inspection_vehicle_color_new)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_vehicle_color_new')).':' }}
                    </span>
                        <span>{{ $vcard->inspection_vehicle_color_new }}</span>
                    </div>
                </div>
                @endif
                @if($vcard->inspection_vehicle_year_new)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_vehicle_year_new')).':' }}
                    </span>
                        <span>{{ $vcard->inspection_vehicle_year_new }}</span>
                    </div>
                </div>
                @endif
                @if($vcard->inspection_plate_no_new)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_plate_no_new')).':' }}
                    </span>
                        <span>{{ $vcard->inspection_plate_no_new }}</span>
                    </div>
                </div>
                @endif
                @if($vcard->inspection_contact_new)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_contact_new')).':' }}
                    </span>
                        <span>{{ $vcard->inspection_contact_new }}</span>
                    </div>
                </div>
                @endif
                @if($vcard->inspection_ar_no_new)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_ar_no_new')).':' }}
                    </span>
                        <span>{{ $vcard->inspection_ar_no_new }}</span>
                    </div>
                </div>
                @endif
                @if($vcard->inspectionCountry)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_country_new')).':' }}
                    </span>
                        <span>{{ $vcard->inspectionCountry->name }}</span>
                    </div>
                </div>
                @endif
                @if($vcard->inspectionState)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_state_new')).':' }}
                    </span>
                        <span>{{ $vcard->inspectionState->name }}</span>
                    </div>
                </div>
                @endif
                @if($vcard->inspectionCity)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_city_new')).':' }}
                    </span>
                        <span>{{ $vcard->inspectionCity->name }}</span>
                    </div>
                </div>
                @endif
                @if($vcard->inspection_district_new)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_district_new')).':' }}
                    </span>
                        <span>{{ $vcard->inspection_district_new }}</span>
                    </div>
                </div>
                @endif
                @if($vcard->inspection_control_technique_new)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_control_technique_new')).':' }}
                    </span>
                        <span class="{{$status =='trail' ? 'text-warning':($status =='active' ? 'text-success':'text-danger') }}">{{ $vcard->inspection_control_technique_new }}</span>
                    </div>
                </div>
                @endif
                @if($vcard->inspection_date_of_inspection_new)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_date_of_inspection_new')).':' }}
                    </span>
                        <span>{{ $vcard->inspection_date_of_inspection_new }}</span>
                    </div>
                </div>
                @endif
                @if($status)
                <div class="col-sm-6 col-12">
                    <div class="card business-card flex-row justify-content-center">
                    <span class="me-2">
                        {{ strtoupper(__('messages.vcard.inspection_date_of_expiration_new')).':' }}
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
        @if(checkFeature('parking_custom_idea') && $vcard->parking_owner_mobile_no)
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
                        @if($vcard->parkingCountry)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_country')).':' }}
                            </span>
                                <span>{{ $vcard->parkingCountry->name }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->parkingState)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_state')).':' }}
                            </span>
                                <span>{{ $vcard->parkingState->name }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->parkingCity)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.parking_city')).':' }}
                            </span>
                                <span>{{ $vcard->parkingCity->name }}</span>
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
        {{-- custom ID --}}
        @if(checkFeature('custom_id') && $vcard->issue_date)
            <div class="vcard-one__timing py-3 px-1">
                <h4 class="vcard-one-heading text-center pb-4">{{ __('messages.vcard.custom_id') }}</h4>
                <div class="container pb-4">
                    <div class="row g-3">
                        @if($vcard->nationality)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.nationality')).':' }}
                            </span>
                                <span>{{ $vcard->nationality }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->footer_text)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.footer_text')).':' }}
                            </span>
                                <span>{{ $vcard->footer_text }}</span>
                            </div>
                        </div>
                        @endif

                        @if($vcard->issue_date)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.issue_date')).':' }}
                            </span>
                                <span>{{ $vcard->issue_date }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->expire_date)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.expire_date')).':' }}
                            </span>
                                <span>{{ $vcard->expire_date }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->company)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.company')).':' }}
                            </span>
                                <span>{{ $vcard->company }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->hair_color)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.hair_color')).':' }}
                            </span>
                                <span>{{ $vcard->hair_color }}</span>
                            </div>
                        </div>
                        @endif
                        {{--  @if($vcard->made_by_url)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.made_by_url')).':' }}
                            </span>
                                <span>{{ $vcard->made_by_url }}</span>
                            </div>
                        </div>
                        @endif  --}}
                        @if($vcard->eye_color)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.eye_color')).':' }}
                            </span>
                                <span>{{ $vcard->eye_color }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->sex)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.sex')).':' }}
                            </span>
                                <span>{{ $vcard->sex }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->type)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.type')).':' }}
                            </span>
                                <span>{{ $vcard->type }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->height)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.height')).':' }}
                            </span>
                                <span>{{ $vcard->height }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->weight)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.weight')).':' }}
                            </span>
                                <span>{{ $vcard->weight }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->rstr)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.rstr')).':' }}
                            </span>
                                <span>{{ $vcard->rstr }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->comercial)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.comercial')).':' }}
                            </span>
                                <span>{{ $vcard->comercial }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->non_comercial)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.non_comercial')).':' }}
                            </span>
                                <span>{{ $vcard->non_comercial }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->dd)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.dd')).':' }}
                            </span>
                                <span>{{ $vcard->dd }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->address)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.address')).':' }}
                            </span>
                                <span>{{ $vcard->address }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->id_back)
                        <div class="col-lg-6 col-sm-6">
                            <div class="mb-3" io-image-input="true">
                                <div class="card business-card flex-row justify-content-center">
                                    <span class="me-2">
                                        {{ __('messages.vcard.id_back').':' }}
                                    </span>
                                </div>
                                <div class="d-block">
                                    <div class="image-picker">
                                        <div class="image previewImage" id="exampleInputIDBack2"
                                            style="background-image: url({{ !empty($vcard->id_back) ? $vcard->id_back : "" }})"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text text-danger" id="idBack2ValidationErrors"></div>
                        </div>
                        @endif
                        @if($vcard->id_back2)
                        <div class="col-lg-6 col-sm-6">
                            <div class="mb-3" io-image-input="true">
                                <div class="card business-card flex-row justify-content-center">
                                    <span class="me-2">
                                        {{ __('messages.vcard.id_back2').':' }}
                                    </span>
                                </div>
                                <div class="d-block">
                                    <div class="image-picker">
                                        <div class="image previewImage" id="exampleInputIDBack2"
                                            style="background-image: url({{ !empty($vcard->id_back2) ? $vcard->id_back2 : "" }})"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text text-danger" id="idBack2ValidationErrors"></div>
                        </div>
                        @endif

                        @if($vcard->category_a)
                        <div class="col-lg-6 col-sm-6">
                            <div class="mb-3" io-image-input="true">
                                <div class="card business-card flex-row justify-content-center">
                                    <span class="me-2">
                                        {{ __('messages.vcard.category_a').':' }}
                                    </span>
                                </div>
                                <div class="d-block">
                                    <div class="image-picker">
                                        <div class="image previewImage" id="exampleInputIDBack2"
                                            style="background-image: url({{ !empty($vcard->category_a) ? $vcard->category_a : "" }})"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text text-danger" id="idBack2ValidationErrors"></div>
                        </div>
                        @endif
                        @if($vcard->category_a_text)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.category_a_text')).':' }}
                            </span>
                                <span>{{ $vcard->category_a_text }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->category_b)
                        <div class="col-lg-6 col-sm-6">
                            <div class="mb-3" io-image-input="true">
                                <div class="card business-card flex-row justify-content-center">
                                    <span class="me-2">
                                        {{ __('messages.vcard.category_b').':' }}
                                    </span>
                                </div>
                                <div class="d-block">
                                    <div class="image-picker">
                                        <div class="image previewImage" id="exampleInputIDBack2"
                                            style="background-image: url({{ !empty($vcard->category_b) ? $vcard->category_b : "" }})"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text text-danger" id="idBack2ValidationErrors"></div>
                        </div>
                        @endif
                        @if($vcard->category_b_text)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.category_b_text')).':' }}
                            </span>
                                <span>{{ $vcard->category_b_text }}</span>
                            </div>
                        </div>
                        @endif


                        @if($vcard->category_c)
                        <div class="col-lg-6 col-sm-6">
                            <div class="mb-3" io-image-input="true">
                                <div class="card business-card flex-row justify-content-center">
                                    <span class="me-2">
                                        {{ __('messages.vcard.category_c').':' }}
                                    </span>
                                </div>
                                <div class="d-block">
                                    <div class="image-picker">
                                        <div class="image previewImage" id="exampleInputIDBack2"
                                            style="background-image: url({{ !empty($vcard->category_c) ? $vcard->category_c : "" }})"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text text-danger" id="idBack2ValidationErrors"></div>
                        </div>
                        @endif
                        @if($vcard->category_c_text)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.category_c_text')).':' }}
                            </span>
                                <span>{{ $vcard->category_c_text }}</span>
                            </div>
                        </div>
                        @endif
                        @if($vcard->category_d)
                        <div class="col-lg-6 col-sm-6">
                            <div class="mb-3" io-image-input="true">
                                <div class="card business-card flex-row justify-content-center">
                                    <span class="me-2">
                                        {{ __('messages.vcard.category_d').':' }}
                                    </span>
                                </div>
                                <div class="d-block">
                                    <div class="image-picker">
                                        <div class="image previewImage" id="exampleInputIDBack2"
                                            style="background-image: url({{ !empty($vcard->category_d) ? $vcard->category_d : "" }})"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text text-danger" id="idBack2ValidationErrors"></div>
                        </div>
                        @endif
                        @if($vcard->category_d_text)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.category_d_text')).':' }}
                            </span>
                                <span>{{ $vcard->category_d_text }}</span>
                            </div>
                        </div>
                        @endif



                        @if($vcard->category_e)
                        <div class="col-lg-6 col-sm-6">
                            <div class="mb-3" io-image-input="true">
                                <div class="card business-card flex-row justify-content-center">
                                    <span class="me-2">
                                        {{ __('messages.vcard.category_e').':' }}
                                    </span>
                                </div>
                                <div class="d-block">
                                    <div class="image-picker">
                                        <div class="image previewImage" id="exampleInputIDBack2"
                                            style="background-image: url({{ !empty($vcard->category_e) ? $vcard->category_e : "" }})"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text text-danger" id="idBack2ValidationErrors"></div>
                        </div>
                        @endif
                        @if($vcard->category_e_text)
                        <div class="col-sm-6 col-12">
                            <div class="card business-card flex-row justify-content-center">
                            <span class="me-2">
                                {{ strtoupper(__('messages.vcard.category_e_text')).':' }}
                            </span>
                                <span>{{ $vcard->category_e_text }}</span>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        @endif
        {{--Appointment--}}
        @if(checkFeature('appointments') && $vcard->appointmentHours->count())
            <div class="vcard__appointment py-3">
                <h4 class="vcard__heading heading-line text-center pb-4 position-relative">{{__('messages.make_appointments')}}</h4>
                <div class="container">
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
        </div>
        @endif

        {{--contact us--}}
        @php $currentSubs = $vcard->subscriptions()->where('status', \App\Models\Subscription::ACTIVE)->latest()->first() @endphp
        <div class="vcard__contact-us pb-5 pt-4">
            @if($currentSubs && $currentSubs->plan->planFeature->enquiry_form)
                <div class="px-4">
                    <h4 class="vcard__heading text-center pb-4">{{ __('messages.contact_us.contact_us') }}</h4>
                    <form id="enquiryForm">
                        @csrf
                        <div class="contact-form px-sm-5">
                            <div id="enquiryError" class="alert alert-danger d-none"></div>
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" id="name"
                                       placeholder="{{__('messages.form.your_name')}}">
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" id="email"
                                       placeholder="{{__('messages.form.your_email')}}">
                            </div>
                            <div class="mb-3">
                                <input type="tel" name="phone" class="form-control" id="phone"
                                       placeholder="{{__('messages.form.enter_phone')}}">
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" placeholder="{{__('messages.form.type_message')}}"
                                          name="message" id="message"
                                          rows="5"></textarea>
                            </div>
                            <button type="submit"
                                    class="contact-btn text-white mt-4 d-block mx-auto">{{ __('messages.contact_us.send_message') }}
                            </button>
                        </div>
                    </form>
                </div>
            @endif
            <div class="d-sm-flex justify-content-center mt-5 pb-5">
                <button type="button" class="vcard-four-btn text-white mt-4 d-block me-2"
                        onclick="downloadVcard('{{ $vcard->name }}.vcf',{{ $vcard->id }})"><i
                            class="fas fa-download me-2"></i>{{ __('messages.vcard.download_vcard') }}</button>
                {{--share btn--}}
                <button type="button" class="vcard4-share share-btn text-white d-block btn mt-4">
                    <a class="text-white text-decoration-none">
                        <i class="text-white fas fa-share-alt me-2"></i>{{ __('messages.vcard.share') }}</a>
                </button>
            </div>
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
                    <small>{{ __('messages.made_by') }} {{ $setting['app_name'] }}</small>
                </div>
            @endif
            @if(!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                <div>
                    <a class="text-decoration-none text-dark cursor-pointer terms-policies-btn"><small>{{__('messages.vcard.term_policy')}}</small></a>
                </div>
            @endif
        </div>
    </div>
    <div class="vcard main-content w-100 mx-auto content-blur collapse terms-policies-section">
        <div class="vcard__contact-us py-5">
            @if(!empty($vcard->privacy_policy) && checkFeature('privacy_policy'))
                <div class="container">
                    <h4 class="vcard__heading text-center py-4 heading-title">{{ __('messages.vcard.privacy_policy') }}</h4>
                    <div class="card px-sm-3 px-4 py-md-5 py-4 m-3">
                        <div class="px-3 ">
                            {!! $vcard->privacy_policy->privacy_policy !!}
                        </div>
                    </div>
                </div>
            @endif
            <hr>
            @if(!empty($vcard->term_condition) && checkFeature('term_condition'))
                <div class="container">
                    <h4 class="vcard__heading text-center py-4 heading-title">{{ __('messages.vcard.term_condition') }}</h4>
                    <div class="card px-sm-3 px-4 py-md-5 py-4 m-3">
                        <div class="px-3 ">
                            {!! $vcard->term_condition->term_condition !!}
                        </div>
                    </div>
                </div>
            @endif
            <div class="text-center mt-3">
                <button class="btn vcard-four-btn px-4 text-white cursor-pointer terms-policies-btn">{{ __('messages.common.back') }}</button>
            </div>
        </div>
    </div>
    {{-- share modal code--}}
    <div id="vcard4-shareModel" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.vcard.share_my_vcard') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                @php
                    $shareUrl = route('vcard.defaultIndex')."/".$vcard->url_alias;
                @endphp
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 justify-content-between social-link-modal">
                            <a href="http://www.facebook.com/sharer.php?u={{$shareUrl}}"
                               target="_blank" class="mx-2 share4" title="Facebook">
                                <i class="fab fa-facebook fa-3x" style="color: #1B95E0"></i>
                            </a>
                            <a href="http://twitter.com/share?url={{$shareUrl}}&text={{$vcard->name}}&hashtags=sharebuttons"
                               target="_blank" class="mx-2 share4" title="Twitter">
                                <i class="fab fa-twitter fa-3x" style="color: #1DA1F3"></i>
                            </a>
                            <a href="http://www.linkedin.com/shareArticle?mini=true&url={{$shareUrl}}"
                               target="_blank" class="mx-2 share4" title="Linkedin">
                                <i class="fab fa-linkedin fa-3x" style="color: #1B95E0"></i>
                            </a>
                            <a href="mailto:?Subject=&Body={{$shareUrl}}" target="_blank"
                               target="_blank" class="mx-2 share4" title="Email">
                                <i class="fas fa-envelope fa-3x" style="color: #191a19  "></i>
                            </a>
                            <a href="http://pinterest.com/pin/create/link/?url={{$shareUrl}}"
                               class="mx-2 share4">
                                <i class="fab fa-pinterest fa-3x" style="color: #bd081c" title="Pinterest"></i>
                            </a>
                            <a href="http://reddit.com/submit?url={{$shareUrl}}&title={{$vcard->name}}"
                               target="_blank" class="mx-2 share4" title="Reddit">
                                <i class="fab fa-reddit fa-3x" style="color: #ff4500"></i>
                            </a>
                            <a href="https://wa.me/?text={{$shareUrl}}" target="_blank" class="mx-2 share4" title="Whatsapp">
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
    $('.testimonial-slider').slick({
        dots: true,
        infinite: true,
        speed: 300,
        arrows: false,
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
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
    $('.product-slider').slick({
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
    $('.gallery-slider').slick({
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
    let vcardAlias = "{{$vcard->url_alias}}"
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
