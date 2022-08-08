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

    {{--css link--}}
    <link rel="stylesheet" href="{{ asset('assets/css/vcard10.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-vcard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">

    {{--google Font--}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&family=Roboto&display=swap" rel="stylesheet">

    <title>{{ $vcard->name }} | {{ getAppName() }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ getFaviconUrl() }}" type="image/png">
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
    <div class="vcard-ten main-content w-100 mx-auto overflow-hidden content-blur collapse show allSection">
        {{--banner--}}
        <div class="vcard-ten__banner w-100 position-relative px-2">
            <img src="{{ $vcard->cover_url }}" class="img-fluid banner-image" alt="banner"/>
            <div class="d-flex justify-content-end position-absolute top-0 end-0 me-3">
                @if($vcard->language_enable == \App\Models\Vcard::LANGUAGE_ENABLE)
                    <div class="language pt-4 me-2">
                        <ul class="text-decoration-none">
                            <li class="dropdown1 dropdown lang-list">
                                <a class="dropdown-toggle lang-head text-decoration-none" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-language me-2"></i>{{getLanguage($vcard->default_language)}}
                                </a>
                                <ul class="dropdown-menu start-0 top-dropdown lang-hover-list top-100">
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
        {{--profile--}}
        <div
            class="vcard-ten__profile position-relative shadow mx-sm-5 mx-4 d-flex flex-sm-row flex-column justify-content-center align-items-center">
            <div class="avatar">
                <img src="{{ $vcard->profile_url }}" alt="profile-img" class="rounded-circle"/>
            </div>
            <div class="mx-4 mt-sm-0 mt-3">
                <h4 class="profile-name text-sm-start text-center">{{ ucwords($vcard->first_name.' '.$vcard->last_name) }}</h4>
                <span class="profile-designation text-sm-start text-center d-block">{{ ucwords($vcard->occupation) }}</span>
            </div>
        </div>
        {{--profile details--}}

        <div class="vcard-ten__profile-details py-4 px-3">
            @if(checkFeature('social_links') && getSocialLink($vcard))
                <div class="social-icons d-flex justify-content-center pt-4 flex-wrap">
                    @foreach(getSocialLink($vcard) as $value)
                        {!! $value !!}
                    @endforeach
                </div>
            @endif
        </div>

        {{--event--}}
        <div class="vcard-ten__event py-4 px-sm-3 px-2 position-relative">
            <div class="container mt-4">
                <div class="row g-3">
                    @if($vcard->email)
                        <div class="col-sm-6 col-12">
                            <div class="card event-card p-3 h-100 border-0 flex-sm-row flex-column align-items-center shadow">
                            <span class="event-icon d-flex justify-content-center align-items-center">
                                <img src="{{asset('assets/img/vcard10/vcard10-email.png')}}" alt="email"/>
                            </span>
                                <div class="event-detail ms-sm-3 mt-sm-0 mt-4">
                                    <h6 class="event-title text-sm-start text-center">{{ __('messages.vcard.email_address') }}</h6>
                                    <h5><a href="mailto:{{ $vcard->email }}" class="event-name text-sm-start text-center mb-0 text-decoration-none">{{ $vcard->email }}</a></h5>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($vcard->phone)
                        <div class="col-sm-6 col-12">
                            <div class="card event-card p-3 h-100 border-0 flex-sm-row flex-column align-items-center shadow">
                            <span class="event-icon d-flex justify-content-center align-items-center">
                                <img src="{{asset('assets/img/vcard10/vcard10-phone.png')}}" alt="phone"/>
                            </span>
                                <div class="event-detail ms-sm-3 mt-sm-0 mt-4">
                                    <h6 class="event-title text-sm-start text-center">{{ __('messages.vcard.mobile_number') }}</h6>
                                    <h5><a href="tel:{{ $vcard->phone }}"
                                           class="event-name text-sm-start text-center mb-0 text-decoration-none">+{{ $vcard->region_code }} {{ $vcard->phone }}</a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($vcard->dob)
                        <div class="col-sm-6 col-12">
                            <div class="card event-card p-3 h-100 border-0 flex-sm-row flex-column align-items-center shadow">
                            <span class="event-icon d-flex justify-content-center align-items-center">
                                <img src="{{asset('assets/img/vcard10/vcard10-birthday.png')}}" alt="birthday"/>
                            </span>
                                <div class="event-detail ms-sm-3 mt-sm-0 mt-4">
                                    <h6 class="event-title text-sm-start text-center">{{ __('messages.vcard.dob') }}</h6>
                                    <h5 class="event-name text-sm-start text-center mb-0">{{ \Carbon\Carbon::parse($vcard->dob)->format('dS F, Y') }}</h5>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($vcard->location)
                        <div class="col-sm-6 col-12">
                            <div class="card event-card p-3 h-100 border-0 flex-sm-row flex-column align-items-center shadow">
                            <span class="event-icon d-flex justify-content-center align-items-center">
                                <img src="{{asset('assets/img/vcard10/vcard10-location.png')}}" alt="location"/>
                            </span>
                                <div class="event-detail ms-sm-3 mt-sm-0 mt-4">
                                    <h6 class="event-title text-sm-start text-center">{{ __('messages.vcard.location') }}</h6>
                                    <h5 class="event-name text-sm-start text-center mb-0">{!! ucwords($vcard->location) !!}</h5>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{--service--}}
       @if(checkFeature('services') && $vcard->services->count())
            <div class="vcard-ten__service py-4 px-sm-3 px-2 position-relative">
                <h4 class="vcard-ten-heading text-center mb-3">{{ __('messages.vcard.our_service') }}</h4>
                <div class="container">
                    <div class="row mt-3 g-3 justify-content-center">
                        @foreach($vcard->services as $service)
                            <div class="col-sm-6 col-12">
                                <div class="card service-card p-3 h-100 d-flex align-items-center shadow border-0">
                                    <div class="service-image d-flex justify-content-center align-items-center">
                                        <img src="{{$service->service_icon}}" class="rounded-circle" alt="service"/>
                                    </div>
                                    <div class="service-details mt-3">
                                        <h5 class="service-title text-center">{{ ucwords($service->name) }}</h5>
                                        <p class="service-paragraph mb-0 text-center">
                                            {!! $service->description !!}
                                        </p>
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
        <div class="vcard-ten__gallery py-4 px-sm-3 px-2 position-relative">
            <h4 class="vcard-ten-heading text-center mb-3">{{ __('messages.plan.gallery') }}</h4>
            <div class="container">
                <div class="row g-3 gallery-slider mt-4">
                    @foreach($vcard->gallery as $file)
                    <div class="col-6">
                        <div class="card gallery-card p-4 border-0 w-100 position-relative shadow">
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

        {{--product--}}
        @if(checkFeature('products') && $vcard->products->count())
            <div class="vcard-ten__product py-4 px-sm-3 px-2 position-relative">
                <h4 class="vcard-ten-heading text-center mb-3">{{ __('messages.plan.products') }}</h4>
                <div class="container">
                    <div class="row g-3 product-slider mt-4">
                        @foreach($vcard->products as $product)
                            <div class="col-6  h-100">
                                <div class="card product-card p-4 border-0 w-100 position-relative shadow h-100 card-height">
                                    <div class="product-profile">
                                        <img src="{{ $product->product_icon }}" alt="profile" class="w-100"
                                             height="208px"/>
                                    </div>
                                    <div class="product-details mt-3">
                                        <h4 class="text-white">{{$product->name}}</h4>
                                        <p class="mb-2 text-white">
                                            {{$product->description}}
                                        </p>
                                        @if($product->currency_id && $product->price)
                                            <span
                                                class="text-whitek">{{$product->currency->currency_icon}}{{$product->price}}</span>
                                        @elseif($product->price)
                                    <span class="text-white">{{$product->price}}</span>
                                @else
                                    <span class="text-white">N/A</span>
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
            <div class="vcard-ten__testimonial py-4 px-sm-3 px-2 position-relative">
                <h4 class="vcard-ten-heading text-center mb-3">{{ __('messages.plan.testimonials') }}</h4>
                <div class="container">
                    <div class="row g-3 testimonial-slider mt-4">
                        @foreach($vcard->testimonials as $testimonial)
                            <div class="col-12 h-100">
                                <div class="card justify-content-between testimonial-card p-4 border-0 w-100 position-relative shadow h-100">
                                    <i class="fas fa-quote-left testimonial-quote"></i>
                                    <p class="review-message mb-3 text-sm-start text-center">
                                        {!! $testimonial->description !!}
                                    </p>
                                    <div class="testimonial-user mt-auto d-flex flex-sm-row flex-column align-items-center justify-content-sm-start justify-content-center">
                                        <img src="{{ $testimonial->image_url }}" alt="profile" class="rounded-circle"/>
                                        <div class="user-details d-flex flex-column ms-sm-3 mt-sm-0 mt-2">
                                            <span class="user-name text-sm-start text-center">{{ ucwords($testimonial->name) }}</span>
                                            <span class="user-designation text-sm-start text-center"></span>
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
            <div class="vcard-ten__blog py-4 px-sm-3 px-2 position-relative">
                <h4 class="vcard-ten-heading text-center mb-3">{{ __('messages.feature.blog') }}</h4>
                <div class="container">
                    <div class="row g-4 blog-slider overflow-hidden">
                        @foreach($vcard->blogs as $blog)
                            <div class="col-6 mb-2">
                                <div class="card blog-card p-5 border-0 w-100 h-100 shadow">
                                    <div class="blog-image">
                                        <a href="{{route('vcard.show-blog',[$vcard->url_alias,$blog->id])}}">
                                            <img src="{{ $blog->blog_icon }}" alt="profile" class="w-100"/>
                                        </a>
                                    </div>
                                    <div class="blog-details mt-12">
                                        <a href="{{route('vcard.show-blog',[$vcard->url_alias,$blog->id])}}" class="text-decoration-none">
                                            <h4 class="text-sm-start text-center title-color p-3 text-black">{{ $blog->title }}</h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        {{--qr code--}}
        <div class="vcard-ten__qr-code py-4 px-sm-3 px-2 position-relative">
            <h4 class="vcard-ten-heading text-center mb-3">{{ __('messages.vcard.qr_code') }}</h4>
            <div class="container">
                <div
                        class="card qr-code-card justify-content-center align-items-center px-sm-3 px-4 pt-15 pb-10 position-relative w-100 mx-auto shadow">
                    <div class="qr-profile mb-3 d-flex justify-content-center position-absolute top-0">
                        <img src="{{$vcard->profile_url}}" alt="qr profile" class="rounded-circle"/>
                    </div>
                    <div class="mt-3 qr-code-scanner mx-md-4 mx-2 p-3 mt-5 mb-5 bg-white">
                        {!! QrCode::size(130)->format('svg')->generate(Request::url()); !!}
                    </div>
                    <div class="mx-2 mb-5 mt-1">
                        <a class="qr-code-btn mt-4 mx-auto text-decoration-none" id="qr-code-btn"
                           download="qr_code.png">{{ __('messages.vcard.download_my_qr_code') }}</a>
                    </div>
                </div>
            </div>
        </div>
        {{--business hour--}}
        @if($vcard->businessHours->count())
            <div class="vcard-ten__timing py-4 px-sm-3 px-2 position-relative">
                <h4 class="vcard-ten-heading text-center mb-3">{{ __('messages.business.business_hours') }}</h4>
                <div class="row mt-4 justify-content-center">
                    <div class="col-sm-8 col-12 time-section px-3 py-1">
                        @foreach($vcard->businessHours as $day)
                            <div class="d-flex justify-content-center time-zone shadow">
                                <span class="me-2">{{ strtoupper(__('messages.business.'.\App\Models\BusinessHour::DAY_OF_WEEK[$day->day_of_week])).':' }}</span>
                                <span>{{ $day->start_time.' - '.$day->end_time }}</span>
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
        {{--Appointment--}}
        @if(checkFeature('appointments') && $vcard->appointmentHours->count())
            <div class="vcard-ten__appointment py-3 px-sm-4 px-3 mt-2 position-relative">
                <h4 class="vcard-ten-heading text-center mb-3">{{__('messages.make_appointments')}}</h4>
                <div class="container">
                    <div class="appointment-card p-3">
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
                                class="appointmentAdd appoint-btn mt-4 d-block mx-auto ">{{__('messages.make_appointments')}}</button>
                    </div>
                </div>
        </div>
            @include('vcardTemplates.appointment')
        @endif


        {{--contact--}}
        @php $currentSubs = $vcard->subscriptions()->where('status', \App\Models\Subscription::ACTIVE)->latest()->first() @endphp
            <div class="vcard-ten__contact py-4 px-sm-3 px-2 position-relative">
                @if($currentSubs && $currentSubs->plan->planFeature->enquiry_form)
                    <h4 class="vcard-ten-heading text-center mb-3">{{ __('messages.contact_us.contact_us') }}</h4>
                    <div class="container">
                        <div class="row mt-4">
                            <div class="col-12">
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
                                                   placeholder="{{__('messages.form.phone')}}">
                                        </div>
                                        <div class="mb-3">
                                            <textarea class="form-control" name="message"
                                                      placeholder="{{__('messages.form.type_message')}}" id="message"
                                                      rows="5"></textarea>
                                        </div>
                                        <button type="submit"
                                                class="contact-btn mt-4 d-block mx-auto">{{ __('messages.contact_us.send_message') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="d-sm-flex justify-content-center mt-5 pb-5">
                    <button type="submit" class="vcard-ten-btn mt-4 d-block btn shadow"
                            onclick="downloadVcard('{{ $vcard->name }}.vcf',{{ $vcard->id }})"><i
                                class="fas fa-download me-2"></i>{{ __('messages.vcard.download_vcard') }}</button>

                    {{--share btn--}}
                    <button type="button" class="vcard10-share share-btn d-block btn mt-4 ms-sm-3">
                        <a class="text-decoration-none">
                            <i class="fas fa-share-alt me-2"></i>{{ __('messages.vcard.share') }}</a>
                    </button>
                </div>
                @if($vcard->location_url && isset($url[5]))
                    <div class="m-2 ">
                        <iframe width="100%" height="300px"
                                src='https://maps.google.de/maps?q={{$url[5]}}/&output=embed' frameborder="0"
                                scrolling="no" marginheight="0" marginwidth="0" style="border-radius: 10px;"></iframe>
                    </div>
                    @endif
                    <div class="d-flex justify-content-evenly">
                        @if(!isset(checkFeature('advanced')->hide_branding) || $vcard->branding == 0)
                            <div class="text-center">
                                <small class="text-light">{{ __('messages.made_by') }} {{ $setting['app_name'] }}</small>
                            </div>
                        @endif
                        @if(!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                            <div>
                                <a class="text-decoration-none text-white cursor-pointer terms-policies-btn"><small>{{__('messages.vcard.term_policy')}}</small></a>
                            </div>
                        @endif
                    </div>
            </div>

        {{-- share modal code--}}
        <div id="vcard10-shareModel" class="modal fade" role="dialog">
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
                                       target="_blank" class="mx-2 share10" title="Facebook">
                                        <i class="fab fa-facebook fa-3x" style="color: #1B95E0"></i>
                                    </a>
                                    <a href="http://twitter.com/share?url={{$shareUrl}}&text={{$vcard->name}}&hashtags=sharebuttons"
                                       target="_blank" class="mx-2 share10" title="Twitter">
                                        <i class="fab fa-twitter fa-3x" style="color: #1DA1F3"></i>
                                    </a>
                                    <a href="http://www.linkedin.com/shareArticle?mini=true&url={{$shareUrl}}"
                                       target="_blank" class="mx-2 share10" title="Linkedin">
                                        <i class="fab fa-linkedin fa-3x" style="color: #1B95E0"></i>
                                    </a>
                                    <a href="mailto:?Subject=&Body={{$shareUrl}}" target="_blank"
                                       class="mx-2 share10" title="Email">
                                        <i class="fas fa-envelope fa-3x" style="color: #191a19  "></i>
                                    </a>
                                    <a href="http://pinterest.com/pin/create/link/?url={{$shareUrl}}"
                                       target="_blank" class="mx-2 share10" title="Pinterest">
                                        <i class="fab fa-pinterest fa-3x" style="color: #bd081c"></i>
                                    </a>
                                    <a href="http://reddit.com/submit?url={{$shareUrl}}&title={{$vcard->name}}"
                                       target="_blank" class="mx-2 share10" title="Reddit">
                                        <i class="fab fa-reddit fa-3x" style="color: #ff4500"></i>
                                    </a>
                                    <a href="https://wa.me/?text={{$shareUrl}}" target="_blank" class="mx-2 share10" title="Whatsapp">
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
    <div class="vcard-ten main-content w-100 mx-auto content-blur collapse terms-policies-section">
        <div class="vcard-ten__contact py-5">
            @if(!empty($vcard->privacy_policy))
                <div class="container">
                    <h4 class="vcard-ten-heading text-center py-4 heading-title">{{ __('messages.vcard.privacy_policy') }}</h4>
                    <div class="card px-sm-3 px-4 py-md-5 py-4 m-3">
                        <div class="px-3 ">
                            {!! $vcard->privacy_policy->privacy_policy !!}
                        </div>
                    </div>
                </div>
            @endif
            @if(!empty($vcard->term_condition))
                <div class="container">
                    <h4 class="vcard-ten-heading text-center py-4 heading-title">{{ __('messages.vcard.term_condition') }}</h4>
                    <div class="card px-sm-3 px-4 py-md-5 py-4 m-3">
                        <div class="px-3 ">
                            {!! $vcard->term_condition->term_condition !!}
                        </div>
                    </div>
                </div>
            @endif
            <div class="text-center mt-3">
                <button class="btn vcard-ten-btn px-4 text-white cursor-pointer terms-policies-btn">{{ __('messages.common.back') }}</button>
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
        arrows: false,
        autoplay: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
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
    let slotUrl = "{{route('appointment-session-time')}}";
    let appUrl = "{{ config('app.url') }}";
    let vcardId = {{$vcard->id}};
    let vcardAlias = "{{$vcard->url_alias}}";
    let languageChange = "{{ url('language') }}";
    let paypalUrl = "{{ route('paypal.init') }}"
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
