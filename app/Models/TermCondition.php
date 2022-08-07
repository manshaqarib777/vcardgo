<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'term_condition',
        'vcard_id',
    ];

    const TERM_CONDITION = 'term_condition';
}
