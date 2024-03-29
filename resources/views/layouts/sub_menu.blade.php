@role(App\Models\Role::ROLE_SUPER_ADMIN)
@can("dashboard.index")

<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('sadmin/dashboard*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/dashboard*') ? 'active' : '' }}"
       href="{{ route('sadmin.dashboard') }}">{{ __('messages.dashboard') }}</a>
</li>
@endcan
@can("users.index")

<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('sadmin/users*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/users*') ? 'active' : '' }}"
       href="{{ route('users.index') }}">{{ __('messages.users') }}</a>
</li>
@endcan
@can("vcards.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('sadmin/vcards*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/vcards*') ? 'active' : '' }}"
       href="{{ route('sadmin.vcards.index') }}">{{ __('messages.vcards') }}</a>
</li>
@endcan
@can("vcards-templates.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('sadmin/templates*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/templates*') ? 'active' : '' }}"
       href="{{ route('sadmin.templates.index') }}">{{ __('messages.vcard.template') }}</a>
</li>
@endcan
@can("cash-payments.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('sadmin/planSubscription*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/planSubscription*') ? 'active' : '' }}"
       href="{{ route('subscription.cash') }}">{{ __('messages.cash_payment') }}</a>
</li>
@endcan
@can("subscribed-user-plans.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('sadmin/subscribedPlan*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/subscribedPlan*') ? 'active' : '' }}"
       href="{{ route('subscription.user.plan') }}">{{ __('messages.subscribed_user') }}</a>
</li>
@endcan
@can("plans.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('sadmin/plans*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/plans*') ? 'active' : '' }}"
       href="{{ route('plans.index') }}">{{ __('messages.plans') }}</a>
</li>
@endcan
@can("currencies.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('sadmin/currencies*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/currencies*') ? 'active' : '' }}"
       href="{{ route('currencies.index') }}">{{ __('messages.currency.currencies') }}</a>
</li>
@endcan
@can("countries.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0
    {{ !Request::is('sadmin/countries*', 'sadmin/states*', 'sadmin/cities*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/countries*') ? 'active' : '' }}"
       href="{{ route('countries.index') }}">{{ __('messages.country.countries') }}</a>
</li>
@endcan
@can("states.index")

<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0
    {{ !Request::is('sadmin/countries*', 'sadmin/states*', 'sadmin/cities*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/states*') ? 'active' : '' }}"
       href="{{ route('states.index') }}">{{ __('messages.state.states') }}</a>
</li>
@endcan
@can("cities.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0
    {{ !Request::is('sadmin/countries*', 'sadmin/states*', 'sadmin/cities*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/cities*') ? 'active' : '' }}"
       href="{{ route('cities.index') }}">{{ __('messages.city.cities') }}</a>
</li>
@endcan
@can("languages.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('sadmin/languages*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/languages*') ? 'active' : '' }}"
       href="{{ route('languages.index') }}">{{ __('messages.languages.languages') }}</a>
</li>
@endcan
@can("settings.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('sadmin/settings*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/settings*') ? 'active' : '' }}"
       href="{{ route('setting.index') }}">{{ __('messages.settings') }}</a>
</li>
@endcan
@can("front-cms.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0
    {{ !Request::is('sadmin/front-cms*', 'sadmin/email-subscription*', 'sadmin/features*',
    'sadmin/about-us*', 'sadmin/frontTestimonial*', 'sadmin/contactUs*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/front-cms*') ? 'active' : '' }}"
       href="{{ route('setting.front.cms') }}">{{ __('messages.front_cms.front_cms') }}</a>
</li>
@endcan
@can("subscriptions.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0
    {{ !Request::is('sadmin/front-cms*', 'sadmin/email-subscription*', 'sadmin/features*',
    'sadmin/about-us*', 'sadmin/frontTestimonial*', 'sadmin/contactUs*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/email-subscription*') ? 'active' : '' }}"
       href="{{ route('email.sub.index') }}">{{ __('messages.subscriptions') }}</a>
</li>
@endcan
@can("features.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0
    {{ !Request::is('sadmin/front-cms*', 'sadmin/email-subscription*', 'sadmin/features*',
    'sadmin/about-us*', 'sadmin/frontTestimonial*', 'sadmin/contactUs*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/features*') ? 'active' : '' }}"
       href="{{ route('features.index') }}">{{ __('messages.features') }}</a>
</li>
@endcan
@can("about-us.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0
    {{ !Request::is('sadmin/front-cms*', 'sadmin/email-subscription*', 'sadmin/features*',
    'sadmin/about-us*', 'sadmin/frontTestimonial*', 'sadmin/contactUs*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/about-us*') ? 'active' : '' }}"
       href="{{ route('aboutUs.index') }}">{{ __('messages.about_us.about_us') }}</a>
</li>
@endcan
@can("flag.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0
    {{ !Request::is('sadmin/front-cms*', 'sadmin/email-subscription*', 'sadmin/features*',
    'sadmin/about-us*', 'sadmin/frontTestimonial*', 'sadmin/contactUs*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/frontTestimonial*') ? 'active' : '' }}"
       href="{{ route('frontTestimonials.index') }}">{{ __('messages.vcard.testimonials') }}</a>
</li>
@endcan
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0
    {{ !Request::is('sadmin/front-cms*', 'sadmin/email-subscription*', 'sadmin/features*',
    'sadmin/about-us*', 'sadmin/frontTestimonial*', 'sadmin/contactUs*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('sadmin/contactUs*') ? 'active' : '' }}"
       href="{{ route('contact.contactus') }}">{{ __('messages.contact_us.contact_us') }}</a>
</li>

@endrole

@role(App\Models\Role::ROLE_ADMIN)
@can("dashboard.index")

<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/dashboard*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/dashboard*') ? 'active' : '' }}"
       href="{{ route('admin.dashboard') }}">{{ __('messages.dashboard') }}</a>
</li>
@endcan
@can("user-vcards.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/vcards*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/vcards*') ? 'active' : '' }}"
       href="{{ route('vcards.index') }}">{{ __('messages.vcards') }}</a>
</li>
@endcan
@can("user-enquiries.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/enquiries*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/enquiries*') ? 'active' : '' }}"
       href="{{ route('enquiries.index') }}">{{ __('messages.enquiry') }}</a>
</li>
@endcan
@can("user-appointments.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/appointments*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/appointments*') ? 'active' : '' }}"
       href="{{ route('appointments.index') }}">{{ __('messages.appointments') }}</a>
</li>
@endcan
@can("galleries.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/galleries*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/galleries*') ? 'active' : '' }}"
       href="{{ route('galleries.index') }}">{{ __('messages.vcard.galleries') }}</a>
</li>
@endcan
@can("user-appointments.schedule")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/appointment-schedule*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/galleries*') ? 'active' : '' }}"
       href="{{ route('appointments.schedule') }}">{{ __('messages.vcard.appointments-schedule') }}</a>
</li>
@endcan
@can("user-settings.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/user-setting*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/user-setting*') ? 'active' : '' }}"
       href="{{ route('user.setting.index') }}">{{ __('messages.settings') }}</a>
</li>
@endcan
@can("user-manage-subscriptions.index")
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/manage-subscription*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/manage-subscription*') ? 'active' : '' }}"
       href="{{ route('subscription.index') }}">{{ __('messages.subscription.manage_subscription') }}</a>
</li>
@endcan
@endrole

@can("account-settings.index")

<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('profile*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('profile*') ? 'active' : '' }}"
       href="{{ route('profile.setting') }}">{{ __('messages.user.profile_details') }}</a>
</li>
@endcan

{{-- <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/choose-payment-type*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/choose-payment-type*') ? 'active' : '' }}"
       href="{{ route('subscription.upgrade') }}">{{ __('messages.plans') }}</a>
</li> --}}
