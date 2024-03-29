<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * App\Models\Vcard
 *
 * @property int $id
 * @property string $url_alias
 * @property string $name
 * @property string $occupation
 * @property string $description
 * @property string|null $first_name
 * @property string|null $last_name
 * @property int $template_id
 * @property int $share_btn
 * @property int $status
 * @property string|null $company
 * @property string|null $job_title
 * @property string|null $dob
 * @property string $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $cover_url
 * @property-read mixed $profile_url
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read User $user
 * @method static Builder|Vcard newModelQuery()
 * @method static Builder|Vcard newQuery()
 * @method static Builder|Vcard query()
 * @method static Builder|Vcard whereCompany($value)
 * @method static Builder|Vcard whereCreatedAt($value)
 * @method static Builder|Vcard whereTenantId($value)
 * @method static Builder|Vcard whereDescription($value)
 * @method static Builder|Vcard whereDob($value)
 * @method static Builder|Vcard whereFirstName($value)
 * @method static Builder|Vcard whereId($value)
 * @method static Builder|Vcard whereJobTitle($value)
 * @method static Builder|Vcard whereLastName($value)
 * @method static Builder|Vcard whereName($value)
 * @method static Builder|Vcard whereOccupation($value)
 * @method static Builder|Vcard whereShareBtn($value)
 * @method static Builder|Vcard whereStatus($value)
 * @method static Builder|Vcard whereTemplateId($value)
 * @method static Builder|Vcard whereUpdatedAt($value)
 * @method static Builder|Vcard whereUrlAlias($value)
 * @mixin Eloquent
 * @property string|null $password
 * @property int $branding
 * @property string $font_family
 * @property string $font_size
 * @property string|null $custom_css
 * @property string|null $custom_js
 * @property-read string $template_url
 * @property-read Collection|VcardService[] $services
 * @property-read int|null $services_count
 * @property-read MultiTenant $tenant
 * @method static Builder|Vcard whereBranding($value)
 * @method static Builder|Vcard whereCustomCss($value)
 * @method static Builder|Vcard whereCustomJs($value)
 * @method static Builder|Vcard whereFontFamily($value)
 * @method static Builder|Vcard whereFontSize($value)
 * @method static Builder|Vcard wherePassword($value)
 * @property-read Collection|Testimonial[] $testimonials
 * @property-read int|null $testimonials_count
 * @property-read SocialLink|null $socialLink
 * @property-read Collection|Template[] $templates
 * @property-read int|null $templates_count
 * @property-read Template|null $template
 * @property string|null $email
 * @property float|null $phone
 * @property string|null $location
 * @property-read Collection|BusinessHour[] $businessHours
 * @property-read int|null $business_hours_count
 * @property-read Collection|Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static Builder|Vcard whereEmail($value)
 * @method static Builder|Vcard whereLocation($value)
 * @method static Builder|Vcard wherePhone($value)
 * @property string|null $region_code
 * @property-read Collection|Enquiry[] $enquiry
 * @property-read int|null $enquiry_count
 * @method static Builder|Vcard whereRegionCode($value)
 * @property string|null $location_url
 * @property string|null $site_title
 * @property string|null $home_title
 * @property string $default_language
 * @property integer $language_enable
 * @property string|null $meta_keyword
 * @property string|null $meta_description
 * @property string|null $google_analytics
 * @property-read Collection|Analytic[] $Analytics
 * @property-read int|null $analytics_count
 * @property-read Collection|Appointment[] $appointmentHours
 * @property-read int|null $appointment_hours_count
 * @property-read Collection|VcardBlog[] $blogs
 * @property-read int|null $blogs_count
 * @property-read Collection|Gallery[] $gallery
 * @property-read int|null $gallery_count
 * @property-read mixed $profile_url_base64
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static Builder|Vcard whereGoogleAnalytics($value)
 * @method static Builder|Vcard whereHomeTitle($value)
 * @method static Builder|Vcard whereLocationUrl($value)
 * @method static Builder|Vcard whereMetaDescription($value)
 * @method static Builder|Vcard whereMetaKeyword($value)
 * @method static Builder|Vcard whereSiteTitle($value)
 */
class Vcard extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory, BelongsToTenant, Multitenantable;

    protected $table = 'vcards';

    /**
     * @var string[]
     */
    protected $fillable = [
        'url_alias',
        'name',
        'occupation',
        'description',
        'first_name',
        'last_name',
        'email',
        'region_code',
        'phone',
        'location',
        'location_url',
        'template_id',
        'share_btn',
        'company',
        'job_title',
        'dob',
        'password',
        'branding',
        'font_family',
        'font_size',
        'custom_css',
        'custom_js',
        'status',
        'tenant_id',
        'site_title',
        'home_title',
        'meta_keyword',
        'meta_description',
        'google_analytics',
        'default_language',
        'language_enable',
        'registration_address',
        'registration_chassis_no',
        'registration_vin_no',
        'registration_vehicle_model',
        'registration_vehicle_color',
        'registration_vehicle_year',
        'registration_plate_no',
        'registration_country',
        'registration_state',
        'registration_city',
        'registration_district',
        'registration_commune',
        'registration_emergency_contact_no',
        'registration_ar_no',
        'registration_pcn_no',
        'registration_driver_name',
        'registration_driver_address',
        'registration_driver_emergency_contact_no',
        'registration_driver_extra_field',
        'registration_driver_country',
        'registration_driver_state',
        'registration_driver_city',
        'registration_driver_district',
        'registration_driver_commune',
        'registration_driver',

        'inspection_address',
        'inspection_chassis_no',
        'inspection_vin_no',
        'inspection_vehicle_model',
        'inspection_vehicle_color',
        'inspection_vehicle_year',
        'inspection_plate_no',
        'inspection_contact',
        'inspection_ar_no',
        'inspection_country',
        'inspection_state',
        'inspection_city',
        'inspection_district',
        'inspection_commune',
        'inspection_control_technique',
        'inspection_date_of_inspection',
        'inspection_date_of_expiration',

        'inspection_address_new',
        'inspection_chassis_no_new',
        'inspection_vin_no_new',
        'inspection_vehicle_model_new',
        'inspection_vehicle_color_new',
        'inspection_vehicle_year_new',
        'inspection_plate_no_new',
        'inspection_contact_new',
        'inspection_ar_no_new',
        'inspection_country_new',
        'inspection_state_new',
        'inspection_city_new',
        'inspection_district_new',
        'inspection_commune_new',
        'inspection_control_technique_new',
        'inspection_date_of_inspection_new',
        'inspection_date_of_expiration_new',

        'parking_owner_mobile_no',
        'parking_address',
        'parking_vehicle_color',
        'parking_vehicle_model',
        'parking_plate_no',
        'parking_mobile',
        'parking_country',
        'parking_state',
        'parking_city',
        'parking_district',
        'parking_commune',
        'parking_p_place_of_registration',
        'parking_p_registration_officer',
        'parking_p_date_of_payment',
        'parking_expiration_date',
        'parking_parking_plan',
        'parking_status',
        'parking_date_of_inspection',
        'parking_date_of_expiration',


        "nationality",
        "footer_text",
        "alternative_email",
        "alternative_phone",
        "alternative_region_code",
        "issue_date",
        "expire_date",
        "hair_color",
        "made_by_url",
        "eye_color",
        "sex",
        "type",
        "height",
        "weight",
        "rstr",
        "address",
        "category",
        "barcode_url",
        "qrcode_url",
        "category_a_text",
        "category_b_text",
        "category_c_text",
        "category_d_text",
        "category_e_text",
        "vcard_unique_number",
        "comercial",
        "non_comercial",
        "dd",
        "category_a_checkbox",
        "category_b_checkbox",
        "category_c_checkbox",
        "category_d_checkbox",
        "category_e_checkbox",

    ];

    /**
     * @var string[]
     */
    protected $appends = ['profile_url', 'cover_url', 'profile_url_base64', 'full_name',"id_back","id_back2","registration_driver_image","driver_photo","barcode","qrcode","category_a","category_b","category_c","category_d","category_e"];

    /**
     * Validation rules
     * @var array
     */
    public static $rules = [
        'url_alias'     => 'string|min:6|max:16|unique:vcards,url_alias',
        'name'          => 'string|min:2',
        'occupation'    => 'string',
        'first_name'    => 'string|min:2',
        'description'   => 'string',
        'last_name'     => 'string',
        'company'       => 'nullable|string',
        'job_title'     => 'nullable|string',
        'email'         => 'nullable|email:filter',
        'phone'         => 'nullable',
        'location_url'  =>  'nullable',
    ];

    const PROFILE_PATH = 'vcards/profiles';
    const COVER_PATH = 'vcards/covers';
    const ID_BACK = 'vcards/id_back';
    const ID_BACK2 = 'vcards/id_back2';
    const REGISTRATION_DRIVER_IMAGE = 'vcards/registration_driver_image';
    const BARCODE = 'vcards/barcode';
    const QRCODE = 'vcards/qrcode';
    const CATEGORYA = 'vcards/category_a';
    const CATEGORYB = 'vcards/category_b';
    const CATEGORYC = 'vcards/category_c';
    const CATEGORYD = 'vcards/category_d';
    const CATEGORYE = 'vcards/category_e';
    const LANGUAGE_ENABLE = 1;

    const TEMPLATE_1 = 1;
    const TEMPLATE_2 = 2;
    const TEMPLATE_3 = 3;
    const TEMPLATE_4 = 4;

    const TEMPLATE = [
        self::TEMPLATE_1,
        self::TEMPLATE_2,
        self::TEMPLATE_3,
        self::TEMPLATE_4,
    ];

    const TEMPLATE_URL = [
        self::TEMPLATE_1 => 'assets/images/default_cover_image.jpg',
        self::TEMPLATE_2 => 'assets/images/default_cover_image.jpg',
        self::TEMPLATE_3 => 'assets/images/default_cover_image.jpg',
        self::TEMPLATE_4 => 'assets/images/default_cover_image.jpg',
    ];

    const URL = ["Lorem1"=>"Lorem1","Lorem2"=>"Lorem2","Lorem3"=>"Lorem3","Lorem4"=>"Lorem4","Lorem5"=>"Lorem5","Lorem6"=>"Lorem6","Lorem7"=>"Lorem7","Lorem8"=>"Lorem8","Lorem9"=>"Lorem9","Lorem10"=>"Lorem10","Lorem11"=>"Lorem11","Lorem12"=>"Lorem12","Lorem13"=>"Lorem13","Lorem14"=>"Lorem14","Lorem15"=>"Lorem15","Lorem16"=>"Lorem16","Lorem17"=>"Lorem17","Lorem18"=>"Lorem18","Lorem19"=>"Lorem19","Lorem20"=>"Lorem20"];
    const SEX = ['Male'=>'male', "Female"=>'Female', 'Other'=>'Other'];
    const TYPE = ['A'=>'A', 'B'=>'B', 'AB'=>'AB', 'O'=>'O'];
    const CATEGORY = ['A'=>'A', 'B'=>'B', 'C'=>'C', 'D'=>'D', 'E'=>'E'];
    const COMERCIAL = ['Comercial'=>'Comercial', "Non Comercial"=>'Non Comercial'];

    const FONT_FAMILY = [
        'Poppins'         => 'Default',
        'Roboto'          => 'Roboto',
        'Times New Roman' => 'Times New Roman',
        'Open Sans'       => 'Open Sans',
        'Montserrat'      => 'Montserrat',
        'Lato'            => 'Lato',
        'Raleway'         => 'Raleway',
        'PT Sans'         => 'PT Sans',
        'Merriweather'    => 'Merriweather',
        'Prompt'          => 'Prompt',
        'Work Sans'       => 'Work Sans',
        'Concert One'     => 'Concert One',
    ];

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * @return string
     */
    public function getProfileUrlAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(self::PROFILE_PATH)->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return asset('web/media/avatars/150-26.jpg');
    }

    /**
     * @return mixed
     */
    public function getProfileUrlBase64Attribute()
    {
        $url = asset('web/media/avatars/150-26.jpg');
        /** @var Media $media */
        $media = $this->getMedia(self::PROFILE_PATH)->first();
        if (!empty($media)) {
            $url = $media->getFullUrl();
        }

        return asset('web/media/avatars/150-26.jpg');
    }


    /**
     * @return mixed
     */
    public function getCoverUrlAttribute()
    {
        /** @var Media $media */
        $media = $this->getMedia(self::COVER_PATH)->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return asset('assets/images/default_cover_image.jpg');
    }

    /**
     * @return string
     */
    public function getIdBackAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(self::ID_BACK)->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return "";
    }

    /**
 * @return string
 */
public function getIdBack2Attribute(): string
{
    /** @var Media $media */
    $media = $this->getMedia(self::ID_BACK2)->first();
    if (!empty($media)) {
        return $media->getFullUrl();
    }

    return "";
}

public function getRegistrationDriverImageAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(self::REGISTRATION_DRIVER_IMAGE)->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return "";
    }

/**
 * @return string
 */
public function getBarcodeAttribute(): string
{
    /** @var Media $media */
    $media = $this->getMedia(self::BARCODE)->first();
    if (!empty($media)) {
        return $media->getFullUrl();
    }

    return "";
}

/**
 * @return string
 */
public function getQrcodeAttribute(): string
{
    /** @var Media $media */
    $media = $this->getMedia(self::QRCODE)->first();
    if (!empty($media)) {
        return $media->getFullUrl();
    }

    return "";
}
/**
 * @return string
 */
public function getCategoryAAttribute(): string
{
    /** @var Media $media */
    $media = $this->getMedia(self::CATEGORYA)->first();
    if (!empty($media)) {
        return $media->getFullUrl();
    }

    return "";
}
/**
 * @return string
 */
public function getCategoryBAttribute(): string
{
    /** @var Media $media */
    $media = $this->getMedia(self::CATEGORYB)->first();
    if (!empty($media)) {
        return $media->getFullUrl();
    }

    return "";
}
/**
 * @return string
 */
public function getCategoryCAttribute(): string
{
    /** @var Media $media */
    $media = $this->getMedia(self::CATEGORYC)->first();
    if (!empty($media)) {
        return $media->getFullUrl();
    }

    return "";
}
/**
 * @return string
 */
public function getCategoryDAttribute(): string
{
    /** @var Media $media */
    $media = $this->getMedia(self::CATEGORYD)->first();
    if (!empty($media)) {
        return $media->getFullUrl();
    }

    return "";
}
/**
 * @return string
 */
public function getCategoryEAttribute(): string
{
    /** @var Media $media */
    $media = $this->getMedia(self::CATEGORYE)->first();
    if (!empty($media)) {
        return $media->getFullUrl();
    }

    return "";
}

    /**
     *
     * @return BelongsTo
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class, 'template_id');
    }

    /**
     *
     * @return HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(VcardService::class, 'vcard_id');
    }

    /**
     * @return HasMany
     */
    public function gallery(): HasMany
    {
        return $this->hasMany(Gallery::class, 'vcard_id');
    }

    /**
     *
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'vcard_id');
    }

    /**
     *
     * @return HasMany
     */
    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class, 'vcard_id');
    }

    /**
     *
     * @return HasOne
     */
    public function socialLink(): HasOne
    {
        return $this->hasOne(SocialLink::class, 'vcard_id');
    }

    /**
     *
     * @return HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'tenant_id', 'tenant_id')->where('card_id', $this->id);
    }

    /**
     *
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'tenant_id', 'tenant_id');
    }

    /**
     *
     *
     * @return HasOne
     */
    public function appointmentDetail(): HasOne
    {
        return $this->hasOne(AppointmentDetail::class, 'vcard_id');
    }

    /**
     *
     * @return HasMany
     */
    public function businessHours(): HasMany
    {
        return $this->hasMany(BusinessHour::class, 'vcard_id', 'id');
    }

    public function appointmentHours(): HasMany
    {
        return $this->hasMany(Appointment::class, 'vcard_id', 'id');
    }

    /**
     *
     * @return HasMany
     */
    public function enquiry(): HasMany
    {
        return $this->hasMany(Enquiry::class, 'vcard_id');
    }

    /**
     *
     *
     * @return HasMany
     */
    public function Analytics(): HasMany
    {
        return $this->hasMany(Analytic::class, 'vcard_id');
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(VcardBlog::class, 'vcard_id');
    }

    /**
     *
     *
     * @return HasOne
     */
    public function privacy_policy(): HasOne
    {
        return $this->hasOne(PrivacyPolicy::class, 'vcard_id');
    }

    /**
     *
     *
     * @return HasOne
     */
    public function term_condition(): HasOne
    {
        return $this->hasOne(TermCondition::class, 'vcard_id');
    }

    /**
     *
     *
     * @return BelongsTo
     */
    public function registrationCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'registration_city');
    }

    /**
     *
     *
     * @return BelongsTo
     */
    public function registrationState(): BelongsTo
    {
        return $this->belongsTo(State::class, 'registration_state');
    }

    /**
     *
     *
     * @return BelongsTo
     */
    public function registrationCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'registration_country');
    }


    /**
     *
     *
     * @return BelongsTo
     */
    public function inspectionCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'inspection_city');
    }

    /**
     *
     *
     * @return BelongsTo
     */
    public function inspectionState(): BelongsTo
    {
        return $this->belongsTo(State::class, 'inspection_state');
    }

    /**
     *
     *
     * @return BelongsTo
     */
    public function inspectionCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'inspection_country');
    }


        /**
     *
     *
     * @return BelongsTo
     */
    public function parkingCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'parking_city');
    }

    /**
     *
     *
     * @return BelongsTo
     */
    public function parkingState(): BelongsTo
    {
        return $this->belongsTo(State::class, 'parking_state');
    }

    /**
     *
     *
     * @return BelongsTo
     */
    public function parkingCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'parking_country');
    }

    /**
     *
     *
     * @return BelongsTo
     */
    public function registrationDriverCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'registration_driver_city');
    }

    /**
     *
     *
     * @return BelongsTo
     */
    public function registrationDriverState(): BelongsTo
    {
        return $this->belongsTo(State::class, 'registration_driver_state');
    }

    /**
     *
     *
     * @return BelongsTo
     */
    public function registrationDriverCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'registration_driver_country');
    }
}
