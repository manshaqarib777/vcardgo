<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Gallery
 *
 * @property int $id
 * @property string $type
 * @property string $link
 * @property int $vcard_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Vcard $vcard
 * @method static \Illuminate\Database\Eloquent\Builder|VcardService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VcardService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VcardService query()
 * @method static \Illuminate\Database\Eloquent\Builder|VcardService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VcardService whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VcardService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VcardService whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VcardService whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VcardService whereVcardId($value)
 * @property-read mixed $gallery_image
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereType($value)
 * @mixin \Eloquent
 * @property-read mixed $type_name
 */
class Gallery extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const GALLERY_PATH = 'vcards/gallery';

    protected $table = 'galleries';

    protected $appends = ['gallery_image','type_name'];
    protected $with = ['media'];

    protected $fillable = [
        'type',
        'link',
        'vcard_id',
        'gallery_name',
        'description',
        'suspended_description',
        'date',
        'time',
        'ticket_fine',
        'ticket_status',
        'date_before',
        'fine',
        'agent_name'
    ];

    const TYPE_IMAGE = 0;
    const TYPE_YOUTUBE = 1;

    const TYPE = [
        self::TYPE_IMAGE   => 'Image',
        self::TYPE_YOUTUBE => 'YouTube',
    ];

    const NAME = ["One"=>"One","Two"=>"Two","Three"=>"Three","Four"=>"Four","Five"=>"Five","Six"=>"Six","Seven"=>"Seven","Eight"=>"Eight","Nine"=>"Nine","Ten"=>"Ten"];
    const TICKET_FINE = ["10$"=>"10$","20$"=>"20$","30$"=>"30$","40$"=>"40$","50$"=>"50$","60$"=>"60$","70$"=>"70$","80$"=>"80$","90$"=>"90$","100$"=>"100$"];
    const FINE = ["Suspended"=>"Suspended","Not Suspended"=>"Not Suspended"];
    const TICKET_STATUS = ["Unpaid"=>"Unpaid","Paid"=>"Paid"];
    /**
     * Validation rules
     * @var array
     */
    public static $rules = [
        'type'   => 'required',
        'link'   => 'nullable|url',
    ];

    /**
     * @return string
     */
    public function getGalleryImageAttribute()
    {
        /** @var Media $media */
        $media = $this->getMedia(self::GALLERY_PATH)->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return asset('assets/images/default_service.png');
    }

    /**
     * @return BelongsTo
     */
    public function vcard()
    {
        return $this->belongsTo(Vcard::class, 'vcard_id');
    }


    public function getTypeNameAttribute($value)
    {
        return self::TYPE[$this->type];
    }
}
