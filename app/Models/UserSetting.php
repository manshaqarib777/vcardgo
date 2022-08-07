<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class UserSetting extends Model
{
    
    use InteractsWithMedia,HasFactory;

    protected $table = 'user_settings';

    /**
     * @var array
     */
    protected $fillable = [
        'currency_id',
        'user_id',
        'key',
        'value',
    ];

}
