<?php

use Carbon\Carbon;
use Stripe\Stripe;
use App\Models\City;
use App\Models\Plan;
use App\Models\User;
use App\Models\State;
use App\Models\Vcard;
use App\Models\Country;
use App\Models\Setting;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Template;
use Carbon\CarbonPeriod;
use App\Models\Appointment;
use App\Models\UserSetting;
use App\Models\Subscription;
use App\Models\PaymentGateway;
use App\Models\Role as CustomRole;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;

/**
 *
 * @return Authenticatable|null
 */
function getLogInUser()
{
    return Auth::user();
}

/**
 *
 * @return string[]
 */
function getLanguages()
{
    return User::LANGUAGES;
}

/**
 * @return mixed
 */
function getAppName()
{
    $record = getSuperAdminSettingValue('app_name');

    return (!empty($record)) ? $record : config('app.name');
}

/**
 * @return mixed
 */
function getLogoUrl()
{
    static $settings;

    if (empty($settings)) {
        $settings = Setting::all()->keyBy('key');
    }

    $appLogo = $settings['app_logo'];

    return $appLogo->logo_url;
}

/**
 * @return mixed
 */
function getFaviconUrl()
{
    static $settings;

    if (empty($settings)) {
        $settings = Setting::all()->keyBy('key');
    }

    $favicon = $settings['favicon'];

    return $favicon->favicon_url;
}

/**
 * @param array $input
 * @param string $key
 *
 * @return string|null
 */
function preparePhoneNumber($input, $key)
{
    return (!empty($input[$key])) ? '+'.$input['prefix_code'].$input[$key] : null;
}

/**
 * @return mixed
 */
function getSuperAdminRoleId()
{
    static $admin;

    if (empty($admin)) {
        $admin = Role::whereName(CustomRole::ROLE_SUPER_ADMIN)->first()->id;
    }

    return $admin;
}

/**
 *
 * @return int
 */
function getLogInUserId()
{
    return Auth::user()->id;
}

/**
 *
 * @return mixed
 */
function getLogInTenantId()
{
    return Auth::user()->tenant_id;
}

function getLogInCardId()
{
    return session('card_id');
}

/**
 * @return mixed
 */
function getLoggedInUserRoleId()
{
    static $userRoles;

    if (!isset($userRoles[Auth::id()]) && Auth::check()) {
        $roleID = Auth::user()->roles->first()->id;

        $userRoles[Auth::id()] = $roleID;
    }

    return (Auth::check()) ? $userRoles[Auth::id()] : false;
}

/**
 * @return string
 */
function getDashboardURL()
{
    if (Auth::user()->hasRole(CustomRole::ROLE_SUPER_ADMIN)) {
        return RouteServiceProvider::DASHBOARD;
    } elseif (Auth::user()->hasRole(CustomRole::ROLE_ADMIN)) {
        return RouteServiceProvider::ADMIN_DASHBOARD;
    }

    return RouteServiceProvider::HOME;
}

/**
 *
 * @return array
 */
function getCurrencies()
{
    $currencies = Currency::all();
    foreach ($currencies as $currency) {
        $currencyList[$currency->id] = $currency->currency_icon.' - '.$currency->currency_name;
    }

    return $currencyList;
}

/**
 *
 * @return mixed
 */
function getCountry()
{
    $country = Country::orderBy('name')->pluck('name', 'id')->toArray();

    return $country;
}

/**
 *
 * @return mixed
 */
function getState()
{
    $state = State::orderBy('name')->pluck('name', 'id')->toArray();

    return $state;
}


/**
 *
 * @return mixed
 */
function getCity()
{
    $city = City::orderBy('name')->pluck('name', 'id')->toArray();

    return $city;
}

/**
 *
 *
 * @return string[]
 */
function getPayPalSupportedCurrencies()
{
    return [
        'AUD', 'BRL', 'CAD', 'CNY', 'CZK', 'DKK', 'EUR', 'HKD', 'HUF', 'ILS', 'JPY', 'MYR', 'MXN', 'TWD', 'NZD', 'NOK',
        'PHP', 'PLN', 'GBP', 'RUB', 'SGD', 'SEK', 'CHF', 'THB', 'USD',
    ];
}

/**
 * @param null $templates
 *
 * @return array
 */
function getTemplateUrls($templates = null): array
{
    if (!$templates) {
        $templates = Template::all();
    }

    $templateUrls = array();
    foreach ($templates as $template) {
        $templateUrls[$template->id] = asset($template->path);
    }

    return $templateUrls;
}

/**
 * @param $plan
 *
 * @return array
 */
function getPlanFeature($plan): array
{
    $features = $plan->planFeature->getFillable();
    $planFeatures = array();
    foreach ($features as $feature) {
        $planFeatures[$feature] = $plan->planFeature->$feature;
    }
    arsort($planFeatures);

    return Arr::except($planFeatures, 'plan_id');
}

/**
 * @param $vcard
 *
 * @return array
 */
function getSocialLink($vcard): array
{
    $socialLink = array_values(array_diff($vcard->socialLink->getFillable(), ['vcard_id']));
    $vcardSocials = array();
    foreach ($socialLink as $social) {
        if ($vcard->socialLink->$social) {
            if ($social != 'website') {
                if ($url = parse_url($vcard->socialLink->$social, PHP_URL_SCHEME) === null ?
                    'https://'.$vcard->socialLink->$social : $vcard->socialLink->$social) {
                    $vcardSocials[$social] =
                        '<a href="'.$url.'" target="_blank">
                        <i class="fab fa-'.$social.' '.$social.'-icon icon fa-2x" title="'.__('messages.social.'.ucfirst($social)).'"></i>
                    </a>';
                }
            } else {
                if ($url = parse_url($vcard->socialLink->$social, PHP_URL_SCHEME) === null ?
                    'https://'.$vcard->socialLink->$social : $vcard->socialLink->$social) {
                    $vcardSocials[$social] =
                        '<a href="'.$url.'" target="_blank">
                        <i class="fa fa-globe-africa globe-africa-icon icon fa-2x" title="'.__('messages.social.website').'"></i>
                    </a>';
                }
            }
        }

        if ($vcard->location_url != null) {
            $vcardSocials['map'] =
                '<a href="'.$vcard->location_url.'" target="_blank">
                        <i class="fas fa-map-marked-alt icon fa-2x" title="'.__('messages.social.map').'"></i>
                    </a>';
        }
    }

    return $vcardSocials;
}

/**
 *
 * @return string[]
 */
function zeroDecimalCurrencies(): array
{
    return [
        'BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'UGX', 'VND', 'VUV', 'XAF', 'XOF', 'XPF',
    ];
}

function getAppLogo()
{
    return getSuperAdminSettingValue('app_logo');
}

/**
 * @param $number
 *
 * @return mixed|string|string[]
 */
function removeCommaFromNumbers($number)
{
    return (gettype($number) == 'string' && !empty($number)) ? str_replace(',', '', $number) : $number;
}

function setStripeApiKey()
{
    Stripe::setApiKey(config('services.stripe.secret_key'));
}

/**
 * @param $index
 *
 * @return string
 */
function getRandomColor($index): string
{
    $badgeColors = [
        'bg-primary',
        'bg-success',
        'bg-info',
        'bg-secondary',
        'bg-dark',
        'bg-danger',
        'bg-warning',
    ];
    $number = ceil($index % 7);

    if (getLogInUser()->theme_mode == 1){
        array_splice($badgeColors, 4, 1);
        array_push($badgeColors,'bg-dark-white');
    }
    return $badgeColors[$number];
}

/**
 *
 * @return mixed
 */
function getCurrentSubscription()
{
//    $subscription = Cache::get('subscription', null);

//    if (empty($subscription)) {
        $subscription = Subscription::with(['plan'])
            ->whereTenantId(getLogInTenantId())
            ->whereCardId(getLogInCardId())
            ->where('status', Subscription::ACTIVE)->latest()->first();

//        Cache::put('subscription', $subscription);
//    }

    return $subscription;
}

function getCurrentPlanDetails()
{
    $currentSubscription = getCurrentSubscription();
    $isExpired = $currentSubscription->isExpired();
    $currentPlan = $currentSubscription->plan;

    if ($currentPlan->price != $currentSubscription->plan_amount) {
        $currentPlan->price = $currentSubscription->plan_amount;
    }

    $startsAt = Carbon::now();
    $totalDays = Carbon::parse($currentSubscription->starts_at)->diffInDays($currentSubscription->ends_at);
    $usedDays = Carbon::parse($currentSubscription->starts_at)->diffInDays($startsAt);
    if ($totalDays > $usedDays) {
        $usedDays = Carbon::parse($currentSubscription->starts_at)->diffInDays($startsAt);
    } else {
        $usedDays = $totalDays;
    }
    if ($totalDays > $usedDays) {
        $remainingDays = $totalDays - $usedDays;
    } else {
        $remainingDays = 0;
    }

    if ($totalDays == 0) {
        $totalDays = 1;
    }

    $frequency = $currentSubscription->plan_frequency == Plan::MONTHLY ? 'Monthly' : 'Yearly';

//    $days = $currentSubscription->plan_frequency == Plan::MONTHLY ? 30 : 365;

    $perDayPrice = round($currentPlan->price / $totalDays, 2);
    if (!empty($currentSubscription->trial_ends_at) || $isExpired) {
        $remainingBalance = 0.00;
        $usedBalance = 0.00;
    } else {
        $isJPYCurrency = !empty($currentPlan->currency) && isJPYCurrency($currentPlan->currency->currency_code);
        $remainingBalance = $currentPlan->price - ($perDayPrice * $usedDays);
        $remainingBalance = $isJPYCurrency ? round($remainingBalance) : $remainingBalance;
        $usedBalance = $currentPlan->price - $remainingBalance;
        $usedBalance = $isJPYCurrency ? round($usedBalance) : $usedBalance;
    }

    return [
        'name'             => $currentPlan->name.' / '.$frequency,
        'trialDays'        => $currentPlan->trial_days,
        'startAt'          => Carbon::parse($currentSubscription->starts_at)->format('jS M, Y'),
        'endsAt'           => Carbon::parse($currentSubscription->ends_at)->format('jS M, Y'),
        'usedDays'         => $usedDays,
        'remainingDays'    => $remainingDays,
        'totalDays'        => $totalDays,
        'usedBalance'      => $usedBalance,
        'remainingBalance' => $remainingBalance,
        'isExpired'        => $isExpired,
        'currentPlan'      => $currentPlan,
    ];
}

function checkIfPlanIsInTrial($currentSubscription)
{
    $now = Carbon::now();
    if (!empty($currentSubscription->trial_ends_at)) {
        return true;
    }

    return false;

}

/**
 * @param $planIDChosenByUser
 *
 * @return array
 */
function getProratedPlanData($planIDChosenByUser)
{
    /** @var Plan $subscriptionPlan */
    $subscriptionPlan = Plan::findOrFail($planIDChosenByUser);
    $newPlanDays = $subscriptionPlan->frequency == Plan::MONTHLY ? 30 : 365;

    $currentSubscription = getCurrentSubscription();
    $frequency = $subscriptionPlan->frequency == Plan::MONTHLY ? 'Monthly' : 'Yearly';

    $startsAt = Carbon::now();

    $carbonParseStartAt = Carbon::parse($currentSubscription->starts_at);
    $currentSubsTotalDays = $carbonParseStartAt->diffInDays($currentSubscription->ends_at);
    $usedDays = $carbonParseStartAt->copy()->diffInDays($startsAt);
    $totalExtraDays = 0;
    $totalDays = $newPlanDays;

    $endsAt = Carbon::now()->addDays($newPlanDays);

    $startsAt = $startsAt->copy()->format('jS M, Y');
    if ($usedDays <= 0) {
        $startsAt = $carbonParseStartAt->copy()->format('jS M, Y');
    }

    if (!$currentSubscription->isExpired() && !checkIfPlanIsInTrial($currentSubscription)) {
        $amountToPay = 0;

        $currentPlan = $currentSubscription->plan; // TODO: take fields from subscription

        // checking if the current active subscription plan has the same price and frequency in order to process the calculation for the proration
        $planPrice = $currentPlan->price;
        $planFrequency = $currentPlan->frequency;
        if ($planPrice != $currentSubscription->plan_amount || $planFrequency != $currentSubscription->plan_frequency) {
            $planPrice = $currentSubscription->plan_amount;
            $planFrequency = $currentSubscription->plan_frequency;
        }

//        $frequencyDays = $planFrequency == Plan::MONTHLY ? 30 : 365;
        $perDayPrice = round($planPrice / $currentSubsTotalDays, 2);
        $isJPYCurrency = !empty($subscriptionPlan->currency) && isJPYCurrency($subscriptionPlan->currency->currency_code);

        $remainingBalance = $isJPYCurrency
            ? round($planPrice - ($perDayPrice * $usedDays))
            : round($planPrice - ($perDayPrice * $usedDays), 2);

        if ($remainingBalance < $subscriptionPlan->price) { // adjust the amount in plan
            $amountToPay = $isJPYCurrency
                ? round($subscriptionPlan->price - $remainingBalance)
                : round($subscriptionPlan->price - $remainingBalance, 2);
        } else {
            $perDayPriceOfNewPlan = round($subscriptionPlan->price / $newPlanDays, 2);
            $totalExtraDays = round($remainingBalance / $perDayPriceOfNewPlan);

            $endsAt = Carbon::now()->addDays($totalExtraDays);
            $totalDays = $totalExtraDays;
        }

        return [
            'startDate'        => $startsAt,
            'name'             => $subscriptionPlan->name.' / '.$frequency,
            'trialDays'        => $subscriptionPlan->trial_days,
            'remainingBalance' => $remainingBalance,
            'endDate'          => $endsAt->format('jS M, Y'),
            'amountToPay'      => $amountToPay,
            'usedDays'         => $usedDays,
            'totalExtraDays'   => $totalExtraDays,
            'totalDays'        => $totalDays,
        ];
    }

    return [
        'name'             => $subscriptionPlan->name.' / '.$frequency,
        'trialDays'        => $subscriptionPlan->trial_days,
        'startDate'        => $startsAt,
        'endDate'          => $endsAt->format('jS M, Y'),
        'remainingBalance' => 0,
        'amountToPay'      => $subscriptionPlan->price,
        'usedDays'         => $usedDays,
        'totalExtraDays'   => $totalExtraDays,
        'totalDays'        => $totalDays,
    ];
}

function YoutubeID($url)
{
    if (strlen($url) > 11) {
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
            $url, $match)) {
            return $match[1];
        } else {
            return false;
        }
    }

    return $url;
}

/**
 * @return array
 */
function isSubscriptionExpired(): array
{
//    $subscription = Cache::get('subscription', null);

//    if (empty($subscription)) {
        $subscription = Subscription::with(['plan'])
            ->whereTenantId(getLogInTenantId())
            ->where('status', Subscription::ACTIVE)->latest()->first();

//        Cache::put('subscription', $subscription);
//    }

    if ($subscription == null) {
        return [
            'status'  => true,
            'message' => 'Please choose a plan to continue the service.',
        ];
    }

    /** @var Subscription $subscription */
    $subscriptionEndDate = Carbon::parse($subscription->trial_ends_at);

    if ($subscription->trial_ends_at == null) {
        $subscriptionEndDate = Carbon::parse($subscription->ends_at);
    }
    $startsAt = Carbon::now();
    $totalDays = Carbon::parse($subscription->starts_at)->diffInDays($subscriptionEndDate);
    $usedDays = Carbon::parse($subscription->starts_at)->diffInDays($startsAt);
    $diffInDays = $totalDays - $usedDays;

//    if ($subscription->ends_at > Carbon::now()) {
//        return [
//            'status' => false,
//        ];
//    }

    $expirationMessage = null;
    if ($diffInDays <= getSuperAdminSettingValue('plan_expire_notification') && $diffInDays > 0) {
        $expirationMessage = __('messages.your')." '{$subscription->plan->name}' ".__('messages.expire_in')." {$diffInDays} ".__('messages.plan.days');
    } else {
        $expirationMessage = __('messages.your')." '{$subscription->plan->name}' ".__('messages.plan_expire');
    }

    return [
        'status'  => $diffInDays <= getSuperAdminSettingValue('plan_expire_notification'),
        'message' => $expirationMessage,
    ];
}

/**
 * @param $plan
 *
 * @return Carbon|null
 */
function setExpiryDate($plan): ?Carbon
{
    $expiryDate = '';
    if ($plan->frequency == Plan::MONTHLY) {
        $date = Carbon::now()->addMonths($plan->valid_upto);
    } elseif ($plan->frequency == Plan::YEARLY) {
        $date = Carbon::now()->addYears($plan->valid_upto);
    } else {
        $expiryDate = null;
    }

    $currentSubs = getCurrentSubscription();
    $remainingDays = '';
    if ($currentSubs->ends_at > Carbon::now()) {
        $remainingDays = Carbon::parse($currentSubs->ends_at)->diffInDays();
    }
    if (isset($date)) {
        $expiryDate = $date->addDays($remainingDays);
    }

    return $expiryDate;
}

/**
 * @param $partName
 *
 * @return bool
 */
function checkFeature($partName)
{
    // if (Auth::check() && getLoggedInUserRoleId() != getSuperAdminRoleId()) {
    //     $currentPlan = getCurrentSubscription()->plan;
    // } else {
        $urlAlias = Route::current()->parameters['alias'];
        $vcard = Vcard::whereUrlAlias($urlAlias)->first();
        if ($vcard) {
            $currentPlan = $vcard->subscriptions()->get()->where('status', 1)->first()->plan;
        } else {
            return false;
        }
    // }

    if ($partName == 'services' && !$currentPlan->planFeature->products_services) {
        return false;
    }
    if ($partName == 'products' && !$currentPlan->planFeature->products) {
        return false;
    }
    if ($partName == 'appointments' && !$currentPlan->planFeature->appointments) {
        return false;
    }
    if ($partName == 'testimonials' && !$currentPlan->planFeature->testimonials) {
        return false;
    }
    if ($partName == 'social_links' && !$currentPlan->planFeature->social_links) {
        return false;
    }
    if ($partName == 'custom_fonts' && !$currentPlan->planFeature->custom_fonts) {
        return false;
    }
    if ($partName == 'gallery' && !$currentPlan->planFeature->gallery) {
        return false;
    }
    if ($partName == 'seo' && !$currentPlan->planFeature->seo) {
        return false;
    }
    if ($partName == 'blog' && !$currentPlan->planFeature->blog) {
        return false;
    }
    if ($partName == 'privacy_policy' && !$currentPlan->planFeature->privacy_policy) {
        return false;
    }
    if ($partName == 'term_condition' && !$currentPlan->planFeature->term_condition) {
        return false;
    }
    if ($partName == 'advanced') {
        $feature = $currentPlan->planFeature;
        if (!$feature->password && !$feature->hide_branding && !$feature->custom_css && !$feature->custom_js) {
            return false;
        }

        return $feature;
    }
    if ($partName == 'privacy_policy' && !$currentPlan->planFeature->privacy_policy) {
        return false;
    }
    if ($partName == 'term_condition' && !$currentPlan->planFeature->term_condition) {
        return false;
    }
    if ($partName == 'business_hours' && !$currentPlan->planFeature->business_hours) {
        return false;
    }
    if ($partName == 'qr_code' && !$currentPlan->planFeature->qr_code) {
        return false;
    }
    if ($partName == 'registration_custom_idea' && !$currentPlan->planFeature->registration_custom_idea) {
        return false;
    }
    if ($partName == 'inspection_custom_idea' && !$currentPlan->planFeature->inspection_custom_idea) {
        return false;
    }
    if ($partName == 'inspection_custom_idea_new' && !$currentPlan->planFeature->inspection_custom_idea_new) {
        return false;
    }
    if ($partName == 'custom_id' && !$currentPlan->planFeature->custom_id) {
        return false;
    }
    if ($partName == 'parking_custom_idea' && !$currentPlan->planFeature->parking_custom_idea) {
        return false;
    }
    return true;
}


/**
 * @param $partName
 *
 * @return bool
 */
function checkFeatureVcard($partName)
{
    if (Auth::check() && getLoggedInUserRoleId() != getSuperAdminRoleId()) {
        $currentPlan = getCurrentSubscription()->plan;
    } else {
        $urlAlias = Route::current()->parameters['alias'];
        $vcard = Vcard::whereUrlAlias($urlAlias)->first();
        if ($vcard) {
            $currentPlan = $vcard->subscriptions()->get()->where('status', 1)->first()->plan;
        } else {
            return false;
        }
    }

    if ($partName == 'services' && !$currentPlan->planFeature->products_services) {
        return false;
    }
    if ($partName == 'products' && !$currentPlan->planFeature->products) {
        return false;
    }
    if ($partName == 'appointments' && !$currentPlan->planFeature->appointments) {
        return false;
    }
    if ($partName == 'testimonials' && !$currentPlan->planFeature->testimonials) {
        return false;
    }
    if ($partName == 'social_links' && !$currentPlan->planFeature->social_links) {
        return false;
    }
    if ($partName == 'custom_fonts' && !$currentPlan->planFeature->custom_fonts) {
        return false;
    }
    if ($partName == 'gallery' && !$currentPlan->planFeature->gallery) {
        return false;
    }
    if ($partName == 'seo' && !$currentPlan->planFeature->seo) {
        return false;
    }
    if ($partName == 'blog' && !$currentPlan->planFeature->blog) {
        return false;
    }
    //dd($partName);
    if ($partName == 'privacy_policy' && !$currentPlan->planFeature->privacy_policy) {
        return false;
    }
    if ($partName == 'term_condition' && !$currentPlan->planFeature->term_condition) {
        return false;
    }
    if ($partName == 'advanced') {
        $feature = $currentPlan->planFeature;
        if (!$feature->password && !$feature->hide_branding && !$feature->custom_css && !$feature->custom_js) {
            return false;
        }

        return $feature;
    }
    if ($partName == 'privacy_policy' && !$currentPlan->planFeature->privacy_policy) {
        return false;
    }
    if ($partName == 'term_condition' && !$currentPlan->planFeature->term_condition) {
        return false;
    }
    if ($partName == 'business_hours' && !$currentPlan->planFeature->business_hours) {
        return false;
    }
    if ($partName == 'qr_code' && !$currentPlan->planFeature->qr_code) {
        return false;
    }
    if ($partName == 'registration_custom_idea' && !$currentPlan->planFeature->registration_custom_idea) {
        return false;
    }
    if ($partName == 'inspection_custom_idea' && !$currentPlan->planFeature->inspection_custom_idea) {
        return false;
    }
    if ($partName == 'inspection_custom_idea_new' && !$currentPlan->planFeature->inspection_custom_idea_new) {
        return false;
    }
    if ($partName == 'custom_id' && !$currentPlan->planFeature->custom_id) {
        return false;
    }
    if ($partName == 'parking_custom_idea' && !$currentPlan->planFeature->parking_custom_idea) {
        return false;
    }
    return true;
}

/**
 *
 *
 * @return bool
 */
function analyticsFeature(): bool
{
    $currentPlan = getCurrentSubscription()->plan;

    if ($currentPlan->planFeature->analytics) {
        return true;
    }

    return false;
}

/**
 * @return int
 */
function planfeaturecount()
{
    $cntcount = 0;
    $planstatus = \App\Models\PlanFeature::wherePlanId(getCurrentSubscription()->plan->id)->first();

    foreach (getPlanFeature(getCurrentSubscription()->plan) as $feature => $value) {

        if ($value) {

            $cntcount++;
        }
    }

    if ($planstatus->enquiry_form == 1) {
        $cntcount--;
    }
    if ($planstatus->hide_branding == 1) {
        $cntcount--;
    }
    if ($planstatus->password == 1) {
        $cntcount--;
    }
    if ($planstatus->custom_js == 1) {
        $cntcount--;
    }
    if ($planstatus->custom_css == 1) {
        $cntcount--;
    }

    return $cntcount;
}

/**
 *
 *
 * @return array
 */
function getSchedulesTimingSlot()
{
    $period = new CarbonPeriod('00:00', "15 minutes", '24:00'); // for create use 24 hours format later change format
    $slots = [];
    foreach ($period as $item) {
        $slots[$item->format("h:i A")] = $item->format("h:i A");
    }

    return $slots;
}

/**
 *
 * @return array
 */
function getBusinessHours(): array
{
    $period = new CarbonPeriod('00:00', "15 minutes", '24:00'); // for create use 24 hours format later change format
    $times = [];
    foreach ($period as $item) {
        $times[$item->format("H:i")] = $item->format("H:i");
    }

    return $times;
}

/**
 * @param $key
 *
 * @return mixed
 */
function getSuperAdminSettingValue($key)
{
    static $settings;

    if (empty($settings)) {
        $settings = Setting::all()->keyBy('key');
    }

    return $settings[$key]->value;
}

/**
 * @param $part
 *
 *
 * @return array|Application|Translator|string|null
 */
function getSuccessMessage($part)
{
    if ($part == null) {
        return __('messages.vcard.basic_details');
    } else {
        if ($part == 'basic') {
            return __('messages.vcard.basic_details');
        } else {
            return __('messages.vcard.'.$part);
        }
    }
}

/**
 *
 *
 * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed|string|null
 */
function getCurrentLanguageName()
{
    return Auth::user()->language;
}

/**
 *
 *
 * @return string
 */
function getSelectedLanguageName()
{
    $languages = getAllLanguage();

    return $languages[checkLanguageSession()];
}

/**
 *
 *
 * @return mixed|string
 */
function checkLanguageSession()
{
    if (Session::has('languageChange')) {
        return Session::get('languageChange');
    }

    return 'en';
}


/**
 * @param $countryName
 *
 *
 * @return string
 */
function get_country_flag($countryName): string
{
    $code = '';
    $countriesArr = json_decode(file_get_contents(storage_path('countries/countries.json')));
    foreach ($countriesArr->countries as $country) {
        if ($country->name == $countryName) {
            $code = country_flag($country->short_code);
        }
    }

    return $code;
}

/**
 *
 *
 * @return string[]
 */
function getPaymentGateway()
{
    $paymentGateway = \App\Models\Subscription::PAYMENT_GATEWAY;
    $selectedPaymentGateway = $selectedPaymentGateways = PaymentGateway::pluck('payment_gateway')->toArray();

    return array_intersect($paymentGateway, $selectedPaymentGateway);
}

/**
 * @return string
 */
function getRandColor(): string
{
    $bgColors = [
        'success',
        'primary',
        'info',
        'success',
        'dark',
        'secondary',
        'danger',
        'warning',
    ];

    $number = ceil(rand() % 7);

    return $bgColors[$number];
}

/**
 *
 *
 * @return mixed|string
 */
function checkFrontLanguageSession()
{
    if (Session::has('languageName')) {
        return Session::get('languageName');
    }

    return 'en';
}

/**
 *
 * @return Language[]|Collection
 */
function getAllLanguage()
{
    return Language::pluck('name', 'iso_code')->toArray();
}


/**
 * @param $index
 *
 * @return string
 */
function getBGColors($index): string
{
    $colors = [
        'rgb(245, 158, 11',
        'rgb(77, 124, 15',
        'rgb(254, 199, 2',
        'rgb(80, 205, 137',
        'rgb(16, 158, 247',
        'rgb(241, 65, 108',
        'rgb(80, 205, 137',
        'rgb(245, 152, 28',
        'rgb(13, 148, 136',
        'rgb(59, 130, 246',
        'rgb(162, 28, 175',
        'rgb(190, 18, 60',
        'rgb(244, 63, 94',
        'rgb(30, 30, 45',
    ];

    return $colors[$index % count($colors)];
}

/**
 * @param $index
 *
 *
 * @return string
 */
function getStatusClassName($status)
{
    $classNames = [
        'bg-status-canceled',
        'bg-status-booked',
        'bg-status-checkIn',
        'bg-status-checkOut',
    ];

    $index = $status % 4;

    return $classNames[$index];
}

/**
 *
 *
 * @return mixed
 */
function getMaximumCurrencyCode()
{
    $plan = Plan::all()->groupBy('currency_id');

    if($plan->isEmpty()){
        return;
    }

    return $plan->first()->first()->currency->currency_code;

}

/**
 * @param $code
 *
 *
 * @return bool
 */
function isJPYCurrency($code)
{
    return Currency::JPY_CODE == $code;
}

/**
 * @param $key
 * @param $userId
 * @return null
 */
function getUserSettingValue($key, $userId)
{
    $value = '';

    $keyExist = UserSetting::where('key', '=', $key)->where('user_id', $userId)->exists();

    if ($keyExist) {
        $value = UserSetting::where('key', '=', $key)->where('user_id', $userId)->first()->value;
    }

    return $value;
}


function getPaymentMethod($userSetting)
{

    $stripeEnable = $userSetting['stripe_enable'];
    $paypalEnable = $userSetting['paypal_enable'];


    if ($stripeEnable && $paypalEnable) {
        $paymentMethod = Appointment::PAYMENT_METHOD;
    } else {
        if ($paypalEnable) {
            $paymentMethod = Appointment::PAYPAL_ARR;
        } else {
            if ($stripeEnable) {
                $paymentMethod = Appointment::STRIPE_ARR;
            } else {
                $paymentMethod = [];
            }
        }
    }

    return $paymentMethod;
}


/**
 * @param $userId
 */
function setUserStripeApiKey($userId)
{
    $setting = UserSetting::where('user_id', $userId)->where('key', 'stripe_secret')->first();
    if (!empty($setting)) {
        $secretKey = $setting->value;
    }

    Stripe::setApiKey($secretKey);
}

/**
 * @param $localeLanguage
 * @return bool
 */
function setLocalLang($localeLanguage): bool
{
    if (!isset($localeLanguage)) {
        App::setLocale('en');
    } else {
        App::setLocale($localeLanguage);
    }

    return true;
}

/**
 * @return string
 */
function getVcardDefaultLanguage(): string
{
    $language = 'en';

    $vcard = Vcard::where('url_alias', request()->alias)->first();

    if (!empty($vcard)) {
        return $vcard->default_language;
    }

    return $language;
}

/**
 * @param $language
 * @return mixed
 */
function getLanguage($language)
{
    $languageIsoCode = Session::get('languageChange_'.request()->alias);

    if (!empty($languageIsoCode)) {
        $language = $languageIsoCode;
    }

    $language = Language::whereIsoCode($language)->first();

    if (!empty($language)) {

        return $language->name;
    }

    return 'English';
}

/**
 * @param $isoCode
 * @return mixed
 */
function getLanguageIsoCode($isoCode)
{
    $languageIsoCode = Session::get('languageChange_'.request()->alias);

    if (!empty($languageIsoCode)) {
        return $languageIsoCode;
    }

    return $isoCode;
}
