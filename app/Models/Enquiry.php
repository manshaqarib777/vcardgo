<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Enquiry
 *
 * @property int $id
 * @property int $vcard_id
 * @property string $name
 * @property string $email
 * @property float|null $phone
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Enquiry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Enquiry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Enquiry query()
 * @method static \Illuminate\Database\Eloquent\Builder|Enquiry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enquiry whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enquiry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enquiry whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enquiry whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enquiry wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enquiry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enquiry whereVcardId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Vcard $vcard
 */
class Enquiry extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    protected $table = 'enquiries';
    protected $appends = ['enquiry_url'];
    const ENQUIRYURL = 'vcards/enquiry_url';
    const REASON = ["Medical Checkup 1"=>"Medical Checkup 1","Medical Checkup 2"=>"Medical Checkup 2","Other"=>"Other"];

    /**
     * @var array
     */
    protected $fillable = [
        'vcard_id',
        'name',
        'email',
        'phone',
        'message',
        'reason',
    ];

    /**
     * @var array
     */
    public static $rules = [
        'name'    => 'required|min:2',
        'email'   => 'required|email:filter',
        'phone'   => 'nullable|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        'message' => 'required|min:2|max:255',
    ];

    /**
     * @return BelongsTo
     */
    public function vcard()
    {
        return $this->belongsTo(Vcard::class);
    }
    /**
     * @return string
     */
    public function getEnquiryUrlAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(self::ENQUIRYURL)->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return "";
    }
}
