<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Appointment
 *
 * @property int $id
 * @property int $vcard_id
 * @property int $day_of_week
 * @property string $start_time
 * @property string $end_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\AppointmentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDayOfWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereVcardId($value)
 * @mixin \Eloquent
 */
class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'vcard_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    const ALL = 0;
    const BOOKED = 1;
    const CHECK_IN = 2;
    const CHECK_OUT = 3;
    const CANCELLED = 4;

    const STATUS = [
        self::BOOKED    => 'Booked',
        self::CHECK_IN  => 'Check In',
        self::CHECK_OUT => 'Check Out',
        self::CANCELLED => 'Cancelled',
    ];

    const STRIPE = 1;
    const PAYPAL = 2;

    const STRIPE_ARR = [
      self::STRIPE => 'Stripe',
    ];
    const PAYPAL_ARR = [
        self::PAYPAL => 'Paypal',
    ];

    const PAYMENT_METHOD = [
        self::STRIPE => 'Stripe',
        self::PAYPAL => 'Paypal',
    ];
    const REASON = ["Medical Checkup 1"=>"Medical Checkup 1","Medical Checkup 2"=>"Medical Checkup 2","Other"=>"Other"];
    const LOCATION = ["Lorem1"=>"Lorem1","Lorem2"=>"Lorem2","Lorem3"=>"Lorem3","Lorem4"=>"Lorem4","Lorem5"=>"Lorem5","Lorem6"=>"Lorem6","Lorem7"=>"Lorem7","Lorem8"=>"Lorem8","Lorem9"=>"Lorem9","Lorem10"=>"Lorem10","Lorem11"=>"Lorem11","Lorem12"=>"Lorem12","Lorem13"=>"Lorem13","Lorem14"=>"Lorem14","Lorem15"=>"Lorem15","Lorem16"=>"Lorem16","Lorem17"=>"Lorem17","Lorem18"=>"Lorem18","Lorem19"=>"Lorem19","Lorem20"=>"Lorem20"];

}
