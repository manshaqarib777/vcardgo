<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'privacy_policy',
        'vcard_id',
    ];

    const PRIVACY_POLICY = 'privacy_policy';
}
